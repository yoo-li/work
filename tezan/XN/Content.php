<?php
/** Defines the XN Content PHP API
 * @file
 * @ingroup XN
 */

/* $Revision: 46419 $ */

/** @cond */
if (! class_exists('XN_Content')) {
/** @endcond */

//############################################################################
// XN_Content
//############################################################################

/** This class represents content stored in the system. Refer to the class
 * details below for example usage.
 * 
 * An XN_Content object has a set number of system attributes and an
 * arbitrary number of developer attributes.
 * 
 * Attributes and properties are accessed through the same mechanisms, ie, 
 * as simulated instance variables accessed through the '->' operator using the
 * magic __get and __set methods, and also through transformer
 * methods such as content, h, htmlentities, and 
 * transform. Explicit get/set/add/remove attribute methods are 
 * provided for functionality not achievable through the '->' mechanism and
 * also can be used in a method-chaining style of invocation. Set/add/remove 
 * content methods are provided as helper functions for manipulating content 
 * references.
 * 
 * Note that only system attributes are stored directly within the XN_Content 
 * attribute container whereas the 'my' attribute container is reserved for 
 * developer defined attributes. Also note that currently not all attribute
 * container methods are supported for system attributes; these are documented
 * below.
 * 
 * Examples of accessing attributes:
 * @code
 * // Print the 'description' system attribute
 * print $c->description;
 * // Set the 'title' system attribute
 * $c->title = 'Books';
 * // Print the 'comment' developer attribute
 * print $c->my->comment;
 * // Set the 'rating' developer attribute
 * $c->my->comment = 'no comment';
 * // Use the method chaining style of setting attributes
 * $content = XN_Content::create('type', 'title', 'description')
 *     ->my->add('url','http://google.com')
 *     ->my->add('title','Days')
 *     ->my->add('day','Monday')
 *     ->my->add('day','Tuesday')
 *     ->my->add('day','Wednesday')
 *     ->my->add('price','1000000',XN_Attribute::NUMBER)
 *     ->my->addContent('stuff', XN_Content::create('stuff')->save())
 *     ->save();
 * // Print the raw 'comment' developer attribute
 * print $c->my->raw('comment');
 * // Print the rawurlencoded 'comment' developer attribute
 * print $c->my->transform('comment', 'rawurlencode');
 * @endcode 
 * 
 * @ingroup XN
 */
class XN_Content {
    /** The DOMNode in which this content object is stored */
    protected $_node;
    
     /** The DOMNode in which this content object is stored */
    public function node()
    { 
    	return $this->_node;
    } 
    /** The DOMXPath object for the DOMDocument that $_node belongs to */
    protected $_x;
    /** Property for accessing developer attributes */
    public $my;

    /** System attributes and their characteristics */
    protected static $_systemAttributes = 
        array(
              'id' => array('callback' => '_lazyLoadCallback'),
			  'published' => array('xpath' => 'atom:published'),
              'createdDate' => array('xpath' => 'atom:published'),
			  'updated' => array('xpath' => 'atom:updated'),
              'updatedDate' => array('xpath' => 'atom:updated'),
              'type' => array('xpath' => 'xn:type'),
              'title' => array('xpath' => 'atom:title',
                               'write' => true),
              'description' => array('xpath' => 'atom:summary',
                                     'write' => true),
              'contributorName' => array('xpath' => 'atom:author/atom:name',
                                         'convert' => 'anonymous'),
	          'author' => array('xpath' => 'atom:author/atom:name',
                                         'convert' => 'anonymous'),
              'application' => array('xpath' => 'xn:application'),					 
              'ownerUrl' => array('xpath' => 'xn:application'),
              
              'ownerName' => array('callback' => '_lazyLoadCallback'),
              'isPrivate' => array('xpath' => 'xn:private',
                                   'write' => true,
                                   'convert' => 'boolean'),
              'tagCount' => array('constant' => 0),
              'data' => array('callback' => '_setDataCallback',
                              'write' => true,
                              'read' => false),
              'contributor' => array('callback' => '_lazyLoadCallback'),
              'owner' => array('callback' => '_lazyLoadCallback')
              );
    /** Set by methods on first use */
    protected static $_xpathForSystemAttributes = '';    
   
    /** @unsupported @internal */
    protected static $_defaultIsPrivate = false;
    /** @unsupported @internal */
    protected $_serializationData;
    /** @unsupported @internal */
    protected $_lazyLoadedData = array();

    /** @unsupported @internal
     * Values of attribute at first load. An element is only set in
     * this array the first time the attribute is changed after load
     */
    public $_valuesAtLoad = array();

    /* @unsupported @internal
     * Numbers assigned to attributes remain as number types in the object,
     * even after save, but when they are loaded, the attribute value becomes a
     * php string. This array is necessary to maintain backwards compatibility 
     * of this "feature".
     */
    protected $_bc_unsavedTypes = array();
    
    protected $_datatype = 0;
    
    public function datatype()
    { 
		if ($this->_datatype == 0 )
		{
			$datatype = $this->_x->textContent('atom:datatype', $this->_node, true);
			if (isset($datatype))
			{
				$this->_datatype = $datatype; 
			}
		} 
    	return $this->_datatype;
    }  
	
    protected $_schedule = 0;
    
    public function schedule()
    {  
    	return $this->_schedule;
    }    

    /* @unsupported @internal 
     * This is public for BC with misusing code (NING-7126) */
    public function __construct($typeOrNode, $titleOrXpath = null, $anonymous = true,$datatype=0) {
        // Creation from existing Node + XPath objects
        //��־�����
        $this->_datatype=$datatype;
        
        if ($typeOrNode instanceof DOMNode) {
            $this->_node = $typeOrNode;
            $this->_x = $titleOrXpath;
            $this->my = new XN_AttributeContainer($this);
            // Make sure $node has the my namespace
            $ns = $this->_node->getAttribute('xmlns:my');
            if ($ns == '') {
                $ns = XN_AtomHelper::NS_APP(XN_Application::load()->relativeUrl);
                $this->_node->setAttribute('xmlns:my', $ns);
            }
            $this->_registerMyNamespace($ns);
            
            // And put it in the per-request cache. A pox on the per-request cache! (NING-7100)
            XN_Cache::_put($this);
            
        }
        // Regular creation from type/title/description 
        else {
            if (! is_null($titleOrXpath)) {
                $titleXml = XN_REST::xmlsprintf('<title type="text">%s</title>', $titleOrXpath);
            } else { $titleXml = ''; }
            //~ if (! is_null($description)) {
                //~ $descXml = XN_REST::xmlsprintf('<summary type="text">%s</summary>', $description);
            //~ } else { $descXml = ''; }
	    if ($anonymous) {
		    $author = XN_AtomHelper::XN_ANONYMOUS;
	    } else {
		    //$p = XN_Profile::current();
		    //$author = XN_Profile::$VIEWER ? XN_Profile::$VIEWER : XN_AtomHelper::XN_ANONYMOUS;
		    $author = XN_Profile::$VIEWER != null ? XN_Profile::$VIEWER : XN_AtomHelper::XN_ANONYMOUS;
	    }
	    $authorXml = XN_REST::xmlsprintf('<author><name>%s</name></author>', $author);
	    
            $this->_buildFromXml(XN_REST::xmlsprintf(trim('
<entry xmlns="%s" xmlns:xn="%s" xmlns:my="%s">
  <xn:type>%s</xn:type>
  '.$titleXml.'
  '.$authorXml.'
  <xn:private>%s</xn:private>
  <xn:application>%s</xn:application>
</entry>'), XN_AtomHelper::NS_ATOM, XN_AtomHelper::NS_XN, 
                                                     XN_AtomHelper::NS_APP(XN_Application::load()->relativeUrl),
                                                     $typeOrNode,
                                                     self::$_defaultIsPrivate ? 'true' : 'false',
						     XN_Application::load()->relativeUrl));
            
        }
    }
    /** @unsupported @internal
     * Helper function for XPath queries relative to the root node for this object */
    protected function _xquery($expr) {
        return $this->_x->query($expr, $this->_node);
    }
    

    
    /** @unsupported @internal */
    protected function _buildFromXml($xml, $root = '/atom:entry') {
        $doc = new DOMDocument();
        $doc->loadXml($xml);
        $this->_x = XN_AtomHelper::XPath($doc);
        $this->_node = $this->_x->query($root)->item(0);
        $this->_registerMyNamespace();
        $this->my = new XN_AttributeContainer($this);
    }

    /**
     * Static factory that creates and returns a new XN_Content object of the 
     * given type. By default the XN_Content object is public.
     * 
     * @param $type string the content type 
     * @param $title string an optional title
     * @param $anonymous Whether to save it as anonymous or not
     * @param $datatype 0 => content, 1 => bigcontent, 2 => mq,3 => simplecontent,4 => maincontent,5 => schedule 
	 * @param $datatype 6 => message,7 => yearcontent,8 => mainyearcontent,9 => yearmonthcontent,10 => mainyearmonthcontent
     * @return XN_Content the XN_Content object
     */
    public static function create($typeOrNode, $titleOrXpath = null, $anonymous = true,$datatype = 0) {
        // If there's already an object with this ID in the cache, return it instead, after
        // enpopulating it with the provided data
        if (is_string($titleOrXpath))
    		$titleOrXpath = str_replace("%", "%%", $titleOrXpath);
        if ($typeOrNode instanceof DOMNode) {
            // NING-7144: accommodate both Rocky and Bullwinkle content
	    $id = self::_idFromAtomEntry($titleOrXpath, $typeOrNode);
	    /*if ($obj = XN_Cache::_get($id, 'XN_Content')) {
                return $obj;
            }*/
        }
        return new XN_Content($typeOrNode, $titleOrXpath, $anonymous,$datatype);
    }

    /** @unsupported @internal 
     * This has to be public so XN_Query can call it, but it shouldn't
     * be called by anyone else */
    public static function createMany(XN_XPathHelper $x,$datatype=0) {
        $objs = array();
        foreach ($x->query('/atom:feed/atom:entry') as $node) {
            $objs[] = self::create($node, $x,false,$datatype);
        }
        return $objs;
    }

    /**
     * Static method that loads and returns one or more {@link XN_Content} objects from 
     * the database for the given content. 
     * 
     * Note that content objects lazily autoload themselves if, after being
     * saved, a system-populated property (except id) is accessed or an
     * attribute is added/modified/removed. There should be no need to 
     * explicitly load a content object using this method if the content object
     * has already been instantiated. 
     * 
     * Throws an {@link XN_Exception} if an error occurred.
     * 
     * @param $content string|XN_Content|array a string content ID, XN_Content object
     * @param $datatype 0 => content, 1 => bigcontent, 2 => mq,3 => simplecontent,4 => maincontent,5 => schedule, 
     * @param $datatype 6 => message,7 => yearcontent,8 => mainyearcontent,9 => yearmonthcontent,10 => mainyearmonthcontent
     * or an array of content IDs or an array of XN_Content objects.
     * @return XN_Content|array the XN_Content object or array of XN_Content objects
     * @see XN_Exception
     */
    public static function load($content,$tag = null,$datatype=0) {
        if (is_array($content)) {
            return self::loadMany($content,$tag,$datatype);
        }
        $id = is_object($content) ? $content->id : $content;
        try {
        	if ($datatype == 0)
        	{
				if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/content(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/content(id=%s)', $id),$headers);
				}
        	}
        	else if($datatype == 1)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/bigcontent(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/bigcontent(id=%s)', $id),$headers);
				}
        	}
        	else if($datatype == 2)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/mq(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/mq(id=%s)', $id),$headers);
				}
        	}
        	else if($datatype == 3)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/simplecontent(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/simplecontent(id=%s)', $id),$headers);
				}
        	}
			else if($datatype == 4)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/maincontent(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/maincontent(id=%s)', $id),$headers);
				}
        	}
			else if($datatype == 5)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/schedule(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/schedule(id=%s)', $id),$headers);
				}
        	}
			else if($datatype == 6)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/message(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/message(id=%s)', $id),$headers);
				}
        	}
			else if($datatype == 7)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/yearcontent(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/yearcontent(id=%s)', $id),$headers);
				}
        	}
			else if($datatype == 8)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearcontent(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearcontent(id=%s)', $id),$headers);
				}
        	}
			else if($datatype == 9)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/yearmonthcontent(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/yearmonthcontent(id=%s)', $id),$headers);
				}
        	}
			else if($datatype == 10)
        	{
        		if ( $tag == null)
				{
					 $rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearmonthcontent(id=%s)', $id));
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearmonthcontent(id=%s)', $id),$headers);
				}
        	}
        	else 
        	{
        		throw new XN_Exception("Failed to load content object");
        	}
            $x = XN_AtomHelper::XPath($rsp);
            $node = $x->query('/atom:feed/atom:entry')->item(0);
            if ($node == null)  throw new XN_Exception("error content id.");             
            $obj = self::create($node, $x,false,$datatype);
	    return $obj;
        } catch (XN_Exception $e) {
            if ($e->getCode() == 404) {
                throw new XN_Exception("'Failed to load content object: ApplicationException: Cannot find content with ID '$id'", 404);
            } else {
                throw $e;
            }
        }
    }

    
    /**
     * Static method that loads and returns an array of {@link XN_Content} 
     * objects from the database for the given array of content ids.
     *  
     * Refer to XN_AttributeContainer::load regarding content autoloading.
     * 
     * Throws an {@link XN_Exception} if an error occurred.
     * 
     * Example of retrieving the XN_Content objects for an array of ids:
     * @code
     * $contents = XN_Content::loadMany($ids);
     * // $contents is an array of XN_Content objects
     * foreach($contents as $content) {
     *     // $content is an XN_Content object
     *     print $content->debugHtml();
     * }
     * @endcode
     * 
     * @param $contents array an array of string ids or XN_Content objects
     * @param $datatype 0 => content, 1 => bigcontent, 2 => mq,      
     * @return array
     * @see XN_Exception
     */ 
  
      public static function loadMany($contents,$tag = null,$datatype=0) {
    		if (count($contents) > 50)
    		{
    			$subcontents = 	array_chunk($contents,50);
    			$result = array();
    			foreach($subcontents as $subcontent_info)
    			{
    				$subresult = XN_Content::load_Many($subcontent_info,$tag,$datatype);
    				$result = array_merge($result,$subresult);
    			}
    			return $result;
    		}
    		else
    		{
    			$result = XN_Content::load_Many($contents,$tag,$datatype);
    			return $result;
    		}
    } 
  
    public static function load_Many($contents,$tag = null,$datatype=0) {
        $ids = array();
        foreach ($contents as $content) {
            $id = is_object($content) ? $content->_id : $content;
            $ids[] = $id;
        }
        // Note that unlike load(), completely missing content objects don't
        // cause an exception to be thrown, they're just omitted from the 
        // results.
        // Errors from the response are passed through
        if ($datatype == 0)
        {
			if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/content(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/content(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
        else if ($datatype == 1)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/bigcontent(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/bigcontent(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
    	else if ($datatype == 2)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/mq(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/mq(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
    	else if ($datatype == 3)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/simplecontent(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/simplecontent(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
		else if ($datatype == 4)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/maincontent(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/maincontent(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
		else if ($datatype == 7)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/yearcontent(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/yearcontent(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
		else if ($datatype == 8)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearcontent(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearcontent(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
		else if ($datatype == 9)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/yearmonthcontent(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/yearmonthcontent(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
		else if ($datatype == 10)
        {
        	if ( $tag == null)
			{
				 $rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearmonthcontent(%s)','id in ['.implode(',',$ids).']'));
			}
			else 
			{
				$headers = array('tag' => $tag);
				$rsp = XN_REST::get(XN_REST::urlsprintf('/mainyearmonthcontent(%s)','id in ['.implode(',',$ids).']'),$headers);
			}
        }
        else 
        {
			throw new XN_Exception("Failed to load content object");
        }
        //$rsp = XN_REST::get(XN_REST::urlsprintf('/content(%s)','id in ['.implode(',',$ids).']'));
        return self::createMany(XN_AtomHelper::XPath($rsp),$datatype);
    }
    
    
    public static function batchsave($objs,$tag = null) 
    {  
		$datatype = -1;
		if (count($objs) ==0) return array();
		$update = false;
		foreach($objs as $obj)
		{
		    if (get_class($obj) != 'XN_Content') throw new XN_Exception("obj classname is not XN_Content");
			if ($datatype == -1) $datatype = $obj->datatype();
			if ($datatype != $obj->datatype()) throw new XN_Exception("datatype not the same.");

			 if ($obj->id) 	$update = true;
		}

		 try {
				if ($datatype == 0 ) 
					$url = '/content';
				else if ($datatype == 1 ) 
					$url = '/bigcontent';
				else if ($datatype == 2 ) 
					$url = '/mq';
				else if ($datatype == 3 ) 
					$url = '/simplecontent';
				else if ($datatype == 4 ) 
					$url = '/maincontent';
				else if ($datatype == 7 ) 
					$url = '/yearcontent';
				else if ($datatype == 8 ) 
					$url = '/mainyearcontent';
				else if ($datatype == 9 ) 
					$url = '/yearmonthcontent';
				else if ($datatype == 10 ) 
					$url = '/mainyearmonthcontent';
				else
					 throw new XN_Exception("Can't save object : datatype");
					 
				$subobjs = 	array_chunk($objs,100);
		        $result = array();
    			foreach($subobjs as $subobj_info)
    			{
    				$xml = '<?xml version="1.0" encoding="UTF-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">';

					foreach($subobj_info as $obj)
					{
						$xml .= $obj->node()->ownerDocument->saveXml($obj->node());	
					}
	
					 $xml .= '</feed>';
							
					if ($update)
					{
						if ( $tag == '')
						{
							 $rsp = XN_REST::put($url, $xml,'text/xml');
						}
						else 
						{
							$headers = array('tag' => $tag);
							$rsp = XN_REST::put($url, $xml,'text/xml',$headers);
						}    
					}
					else
					{
						if ( $tag == '')
						{
							 $rsp = XN_REST::post($url, $xml,'text/xml');
						}
						else 
						{
							$headers = array('tag' => $tag);
							$rsp = XN_REST::post($url, $xml,'text/xml',$headers);
						}    
					}           
					$contents = XN_AtomHelper::loadFromAtomFeed($rsp, 'XN_Content', false);
    				$result = array_merge($result,$contents);
    			}				
				return $result;
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to save content:\n" , $e);
        }
    }

public function setPublished($value) 
    { 
    	$name = "createdDate";
    	$xpath = self::$_systemAttributes[$name]['xpath'];
    	$nodeList = $this->_xquery($xpath);
    	if ($nodeList->length == 0)
    	{
    	 	$node = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_ATOM,$xpath, self::_valueToAtom($value));
    	 	$this->_node->appendChild($node);
    	}
    	else
    	{
    	 	$node = $nodeList->item(0);
    	}
     	foreach ($node->childNodes as $child) {
            $node->removeChild($child);
        }
    	$node->appendChild($node->ownerDocument->createTextNode($value));
    	return $this; 
    }
	public function setUpdated($value) 
    { 
    	$name = "updatedDate";
    	$xpath = self::$_systemAttributes[$name]['xpath'];
    	$nodeList = $this->_xquery($xpath);
    	if ($nodeList->length == 0)
    	{
    	 	$node = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_ATOM,$xpath, self::_valueToAtom($value));
    	 	$this->_node->appendChild($node);
    	}
    	else
    	{
    	 	$node = $nodeList->item(0);
    	}
     	foreach ($node->childNodes as $child) {
            $node->removeChild($child);
        }
    	$node->appendChild($node->ownerDocument->createTextNode($value));
    	return $this;
    }
   /**
     * Saves this XN_Content object, including its {@link XN_Attribute}s,
     * to the database.
     * 
     * For a new XN_Content object, inserts the XN_Content and 
     * XN_Attributes into the database. If the user is logged in, the 
     * contributor of the content is set to the user, else if the user is 
     * anonymous, the contributor of the content is set to null. See 
     * saveAnonymous for forcing new content to be set with a null
     * contributor regardless of the user.
     *
     * For an existing XN_Content object, this method updates the XN_Content 
     * and XN_Attributes in the database. If the visibility of the content is
     * modified, the visibility of the content tags are also modified to the
     * same visibility as the content. If the visibility is changed from public
     * to private, all references to the content from other applications are
     * deleted. See saveCascade for cascading the change in visibility
     * to content objects referenced by this content object.
     *
     * Returns this Content object with an updated id if the save was successful
     * Throws an {@link XN_Exception} if the save failed.
     * @return XN_Content the XN_Content object populated with its database id
     * @see XN_Exception
     */
    public function save($tag = null,$datatype=null) 
	{ 
		if ($datatype!=null)
		{
			$this->_datatype=$datatype;
		}
		return $this->_saveProper(false, false,$tag); 
	}

    /**
     * Saves this XN_Content object, including it's {@link XN_Attribute}s,
     * to the database, and sets the content contributor to null if the content
     * is new.
     * 
     * For a new XN_Content object, inserts the XN_Content and 
     * XN_Attributes into the database with a null content contributor.
     *
     * For an existing XN_Content object, this method updates the XN_Content 
     * and XN_Attributes in the database. If the visibility of the content is
     * modified, the visibility of the content tags are also modified to the
     * same visibility as the content. If the visibility is changed from public
     * to private, all references to the content from other applications are
     * deleted.
     *
     * Returns this Content object with an updated id if the save was successful
     * Throws an {@link XN_Exception} if the save failed.
     * @return XN_Content the XN_Content object populated with its database id
     * @see XN_Exception
     */
    public function saveAnonymous($tag = null) { return $this->_saveProper(true, false,$tag); }
 
    /**
     * Saves this XN_Content object, including it's {@link XN_Attribute}s,
     * to the database, and recursively cascades any change in visibility to 
     * all content objects that are referenced by this content object and owned
     * by the calling application. 
     * 
     * For a new XN_Content object, inserts the XN_Content and 
     * XN_Attributes into the database. If the user is logged in, the 
     * contributor of the content is set to the user, else if the user is 
     * anonymous, the contributor of the content is set to null. See 
     * saveCascadeAnonymous for forcing new content to be set with a 
     * null contributor regardless of the user.
     *
     * For an existing XN_Content object, this method updates the XN_Content 
     * and XN_Attributes in the database. If the visibility of the content is
     * modified, the visibility of the content tags are also modified to the
     * same visibility as the content. If the visibility is changed from public
     * to private, all references to the content from other applications are
     * deleted.
     *
     * Returns this Content object with an updated id if the save was successful
     * Throws an {@link XN_Exception} if the save failed.
     * @return XN_Content the XN_Content object populated with its database id
     * @see XN_Exception
     * @deprecated
     */
    public function saveCascade($tag = null) { return $this->_saveProper(false, true,$tag); }


     /**
     * Saves this XN_Content object, including its {@link XN_Attribute}s,
     * to the database, and recursively cascades any change in visibility to 
     * all content objects that are referenced by this content object and owned
     * by the calling application. 
     * 
     * For a new XN_Content object, inserts the XN_Content and 
     * XN_Attributes into the database with a null content contributor.
     *
     * For an existing XN_Content object, this method updates the XN_Content 
     * and XN_Attributes in the database. If the visibility of the content is
     * modified, the visibility of the content tags are also modified to the
     * same visibility as the content. If the visibility is changed from public
     * to private, all references to the content from other applications are
     * deleted.
     *
     * Returns this Content object with an updated id if the save was successful
     * Throws an {@link XN_Exception} if the save failed.
     * @return XN_Content the XN_Content object populated with its database id
     * @see XN_Exception
     * @depreated
     */
    public function saveAnonymousCascade($tag = null) { return $this->_saveProper(true, true,$tag); } // @deprecated

    /** @unsupported @internal */
    protected function _saveProper($anonymous = false, $cascade = false,$tag = null) {
	// @bc-check: reloadifrequired?
	XN_Event::fire('xn/content/save/before', array($this, $cascade, $anonymous));
	
	/* Turn any attributes of type UPLOADEDFILE or FILEIMAGE into
	 * CONTENT attributes pointing to newly created content objects
	 * holding the binary content */
	foreach ($this->_xquery("my:*[@type='" . XN_Attribute::UPLOADEDFILE . 
                                "' or @type='" . XN_Attribute::FILEIMAGE . "']") as $node) {
 	    $this->_convertUploadedFile($node, $anonymous);
	}
        // For BC: adjust malformed elements of type boolean before saving
        foreach ($this->_xquery("my:*[@xn:type='" . XN_Attribute::BOOLEAN ."']") as $node) {
            $this->_convertValuesToType($node, XN_Attribute::BOOLEAN);
        }

        try {
        	if ($this->_datatype == 0 ) 
        		$url = '/content';
        	else if ($this->_datatype == 1 ) 
        		$url = '/bigcontent';
        	else if ($this->_datatype == 2 ) 
        		$url = '/mq';
        	else if ($this->_datatype == 3 ) 
        		$url = '/simplecontent';
			else if ($this->_datatype == 4 ) 
        		$url = '/maincontent';
			else if ($this->_datatype == 5 ) 
        		$url = '/schedule';
			else if ($this->_datatype == 6 ) 
        		$url = '/message';
			else if ($this->_datatype == 7 ) 
        		$url = '/yearcontent';
			else if ($this->_datatype == 8 ) 
        		$url = '/mainyearcontent';
			else if ($this->_datatype == 9 ) 
        		$url = '/yearmonthcontent';
			else if ($this->_datatype == 10) 
        		$url = '/mainyearmonthcontent';
        	else
            	 throw new XN_Exception("Can't save object : datatype");
            if ($anonymous) {
                $authorNodeList = $this->_xquery('atom:author');
                if ($authorNodeList->length == 1) {
                    $authorNode = $authorNodeList->item(0);
                    foreach ($authorNode->childNodes as $child) { 
                        $authorNode->removeChild($child);
                    }
                    $authorNode->appendChild($this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_ATOM, 'atom:name', XN_AtomHelper::XN_ANONYMOUS));
                }
                elseif ($nameNodeList->length == 0) {
                    $this->_node->appendChild($authorNode = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_ATOM, 'atom:author'));
                    $authorNode->appendChild($this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_ATOM, 'atom:name', XN_AtomHelper::XN_ANONYMOUS));
                } else {
                    throw new XN_Exception("Can't save object as anonymous: unexpected XML");
                }
            }
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">'.$this->_node->ownerDocument->saveXml($this->_node).'</feed>';
            if ($this->id) {
            	if ($this->_datatype == 1)
            	{
            		throw new XN_Exception("Failed to save content: bigcontent can not save!(".$this->_datatype.")\n");
            	}
                $url .= '(id=' . $this->id . ')';                
                //$rsp = XN_REST::put($url, $this->_node->ownerDocument->saveXml($this->_node));		       
	            if ( $tag == null)
				{
					 $rsp = XN_REST::put($url, $xml,'text/xml');
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::put($url, $xml,'text/xml',$headers);
				}
                $this->_x = XN_AtomHelper::XPath($rsp);
                // This updates createdDate and updatedDate which is a BC break
                $this->_node = $this->_x->query('/atom:feed/atom:entry')->item(0);
                // Make sure $node has the my namespace
                $ns = $this->_node->getAttribute('xmlns:my');
                if ($ns == '') {
                    $ns = XN_AtomHelper::NS_APP(XN_Application::load()->relativeUrl);
                    $this->_node->setAttribute('xmlns:my', $ns);
                }
                $this->_registerMyNamespace($ns);
                // If id or contributor has already been looked up, clear it out
                // since it may have changed on first save.
                $this->_lazyLoadedData = array();
            } else {
                //$rsp = XN_REST::post($url, $this->_node->ownerDocument->saveXml($this->_node));
                
                if ( $tag == '')
				{
					 $rsp = XN_REST::post($url, $xml,'text/xml');
				}
				else 
				{
		        	$headers = array('tag' => $tag);
		            $rsp = XN_REST::post($url, $xml,'text/xml',$headers);
					if ($this->_datatype == 5 ) 
					{  
		                $x = XN_AtomHelper::XPath($rsp); 
		                $node = $x->query('/atom:feed/atom:entry')->item(0); 
						if (!$node)
						{
					        $doc = new DomDocument();
					        $doc->loadXML($rsp);
					        $error = $doc->getElementsByTagName('error');
							$errormsg = $error->item(0)->textContent;  
							if (isset($errormsg) && $errormsg != "")
							{ 
								throw new XN_Exception($errormsg); 
							} 
							return array();
						} 
						$this->_schedule = (integer) $x->textContent('/atom:feed/xn:size');
						return XN_Content::createMany($x,5); 
					}
				}               
                $this->_x = XN_AtomHelper::XPath($rsp);
                // This updates createdDate and updatedDate which is a BC break
                $this->_node = $this->_x->query('/atom:feed/atom:entry')->item(0);
                // Make sure $node has the my namespace
				if (!$this->_node)
				{
			        $doc = new DomDocument();
			        $doc->loadXML($rsp);
			        $error = $doc->getElementsByTagName('error');
					$errormsg = $error->item(0)->textContent; 
					throw new XN_Exception($errormsg); 
				}
                $ns = $this->_node->getAttribute('xmlns:my');
                if ($ns == '') {
                    $ns = XN_AtomHelper::NS_APP(XN_Application::load()->relativeUrl);
                    $this->_node->setAttribute('xmlns:my', $ns);
                }
                $this->_registerMyNamespace($ns);
                // If id or contributor has already been looked up, clear it out
                // since it may have changed on first save.
                $this->_lazyLoadedData = array();
            }
            XN_Cache::_put($this);
            XN_Event::fire('xn/content/save/after', array($this, $cascade, $anonymous));
            return $this;
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to save content:\n" , $e);
        }
    }

    /**
     * Static method that deletes the content identified by the given content
     * id or XN_Content object from the database. 
     *
     * When a content object is deleted, all its 
     * {@link XN_Attribute attributes}, {@link XN_Tag tags}, and
     * {@link XN_Attribute::CONTENT references} to it from other content are
     * deleted. Note that {@link XN_Attribute::CONTENT references} are deleted
     * regardless of the owner application of the referencing object.
     *
     * Throws an {@link XN_Exception} if the delete failed.
     * 
     * @param $content mixed either a XN_Content object or a string content ID
     * or an array of content objects and/or content IDs.
     * @see XN_Exception
     */
    public static function delete($content,$tag = null,$datatype=0) {
    	if (is_array($content) && count($content) > 100) 
    	{
    			$subcontents = 	array_chunk($content,100);    			
    			foreach($subcontents as $subcontent_info)
    			{
    				self::_deleteProper($subcontent_info,false,$tag,$datatype);
    			}
    	}
    	else 
    	{
    		self::_deleteProper($content, false,$tag,$datatype); 
    	}
    }


    /**
     * Static method that deletes the content identified by the given content
     * id or XN_Content object, and recursively deletes all content objects
     * that it references that are owned by the calling application. 
     *
     * When a content object is deleted, all its 
     * {@link XN_Attribute attributes}, {@link XN_Tag tags}, and
     * {@link XN_Attribute::CONTENT references} to it from other content are
     * deleted. Note that {@link XN_Attribute::CONTENT references} are deleted
     * regardless of the owner application of the referencing object.
     *
     * Throws an {@link XN_Exception} if the delete failed.
     * 
     * @param $content mixed either a XN_Content object or a string content ID
     * or an array of content objects and/or content IDs.
     * @see XN_Exception
     * @deprecated
     */
    public static function deleteCascade($content,$tag = null,$datatype=0) { return self::_deleteProper($content, true,$tag,$datatype); }

    /** @unsupported @internal */
    protected static function _deleteProper($content, $cascade = false,$tag = null,$datatype=0) {
        if (is_null($content)) { return; } // for BC

        $ids = array();
        if (is_array($content) && count($content) == 0) return;
        if (! is_array($content)) { $content = array($content); }

        XN_Event::fire('xn/content/delete/before', array($content, $cascade));
        foreach ($content as $c) {
            if (is_object($c)) {
                $ids[] = $c->id;
				if ($c->datatype() != 0 )
				{
					$datatype = $c->datatype();
				}
            } else {
                $ids[] = $c;
            }
        }
		if (is_object($content))
		{
			if ($content->datatype() != 0 )
			{
				$datatype = $content->datatype();
			}
		}
		 
        $qs = $cascade ? '?cascade=true' : '';
        try {
             //XN_REST::delete(XN_REST::urlsprintf('/content(%s)','id in ['.implode(',',$ids).']').$qs);
        	 if ($datatype == 0)
        	 {
				 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/content(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/content(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
        	 }
             else if ($datatype == 1)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/bitcontent(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/bitcontent(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
        	 else if ($datatype == 2)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/mq(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/mq(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
        	else if ($datatype == 3)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/simplecontent(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/simplecontent(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
			 else if ($datatype == 4)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/maincontent(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/maincontent(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
			 else if ($datatype == 7)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/yearcontent(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/yearcontent(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
			 else if ($datatype == 8)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/mainyearcontent(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/mainyearcontent(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
			 else if ($datatype == 9)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/yearmonthcontent(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/yearmonthcontent(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
			 else if ($datatype == 10)
             {
             	 if ( $tag == '')
					{
						XN_REST::delete(XN_REST::urlsprintf('/mainyearmonthcontent(%s)','id in ['.implode(',',$ids).']').$qs);
					}
					else 
					{
			        	$headers = array('tag' => $tag);
			            XN_REST::delete(XN_REST::urlsprintf('/mainyearmonthcontent(%s)','id in ['.implode(',',$ids).']').$qs,$headers);
					} 
             }
        	 else {
				 throw XN_Exception::reformat("Failed to delete content: id = '".implode(',',$ids)."'", $e);
        	 }		  
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to delete content: id = '".implode(',',$ids)."'", $e);
        }
        XN_Event::fire('xn/content/delete/after', array($content, $cascade));
    }

    /**
     * Returns a string debug representation of the XN_Content object.
     * @return string a debug string
     */
    public function debugString() {
        $str =  "<br>XN_Content:<br>";
        $str .= "\t\tid [".$this->id."]<br>";
        $str .= "\t\tcreatedDate [".$this->createdDate."]<br>";
        $str .= "\t\tupdatedDate [".$this->updatedDate."]<br>";
        $str .= "\t\ttype [".$this->type."]<br>";
        $str .= "\t\ttitle [".$this->title."]<br>"; 
	  foreach ($this->my->attribute() as $na) {
            if (is_array($na)){
                foreach ($na as $na1) {
                    if (isset($na1)){
                        $str .= "\t\t\t\t\t\t".$na1->name." => ".$na1->value."<br>";
                    }
                }
            }
            else if (isset($na)){
                $str .= "\t\t\t\t".$na->name." => ".$na->value."<br>";
            }
        } 
        return $str;        
    }
    
    /**
     * Returns a debug string representation of the XN_Content object wrapped
     * within an HTML pre tag.
     * @return string a debug string wrapper in html pre tags
     */
    public function debugHtml() {
        return '<pre>' . xnhtmlentities($this->debugString()) . '</pre>';
    }

    /**
     * Frees references in the per-request cache and in internal
     * structures to the content object. Useful to free up memory
     * in long-running scripts. You still need to call unset()
     * on the content object after calling this method.
     *
     * @param $c XN_Content object to free up
     */
    public static function freeReferencesTo(XN_Content &$c) {
        XN_Cache::_remove($c);
        $c->my->___removeFromMap();
    }


    /**
     * Returns a string which uniquely identifies this content object.
     * @return string a string identifying this object
     */
    public function __toString() {
	return "Content Object #{$this->id}";
    }

    /**
     * Read access to system and developer attributes
     *
     * @param $prop string attribute to read
     * @return mixed
     */
    public function __get($prop) {
        /* Developer attribute or system attribute? */
        if (strpos($prop, 'my:') === 0) {
            if (($prop != 'my:*') && XN_Attribute::_isClownString(substr($prop,3))) {
                throw new XN_Exception("Illegal attribute name: my." . substr($prop,3));
            }
            $nodes = $this->_xquery($prop);
            if ($nodes->length == 0) {
                return null;
            }
            $allValues = array();
            // $prop could have found one or more nodes
            foreach ($nodes as $node) {
                $nodeType = $node->getAttributeNS(XN_AtomHelper::NS_XN, 'type');
                $multivalues = $this->_x->query('xn:value', $node);
                // Regular <my:foo>bar</my:foo> node
                if ($multivalues->length == 0) {
                    $value = $node->textContent;
                    if (isset($this->_bc_unsavedTypes[$prop])) {
                        settype($value, $this->_bc_unsavedTypes[$prop]);
                    }
                    else {
                        $value = self::_valueFromAtom($value, $nodeType);
                    }
                    $allValues[$node->localName] = ($nodes->length == 1) ? $value : array($value);
                }
                // <my:foo><xn:value>bar</xn:value></my:foo>
                elseif ($multivalues->length == 1) {
                    $value = $multivalues->item(0)->textContent;
                    if (isset($this->_bc_unsavedTypes[$prop])) {
                        settype($value, $this->_bc_unsavedTypes[$prop]);
                    }
                    else {
                        $value = self::_valueFromAtom($value, $nodeType);
                    }
                    $allValues[$node->localName] = ($nodes->length == 1) ? $value :  array($value);
                }
                // multiple <xn:value children
                else {
                    $values = array();
                    foreach ($multivalues as $multivalue) {
                        $value = $multivalue->textContent;
                        if (isset($this->_bc_unsavedTypes[$prop])) {
                            settype($value, $this->_bc_unsavedTypes[$prop]);
			}
                        else {
                            $value = self::_valueFromAtom($value, $nodeType);
                        }
                        $values[] = $value;
                    }
                    $allValues[$node->localName] = $values;
                }
            }
            return ($nodes->length == 1) ?
                $allValues[$nodes->item(0)->localName] : $allValues;
	} 
        else {
            if (isset(self::$_systemAttributes[$prop])) {
                // If there's a callback specified, use that to compute the value
		if (isset(self::$_systemAttributes[$prop]['callback'])) {
		  if ((! isset(self::$_systemAttributes[$prop]['read'])) ||
		      (self::$_systemAttributes[$prop]['read'] === true)) {
		    $value = call_user_func(array($this,self::$_systemAttributes[$prop]['callback']), 'read', $prop);
		  } else {
		    $value = null;
		  }
		}
                // Otherwise, if there's an xpath expression, specified, use that
		elseif (isset(self::$_systemAttributes[$prop]['xpath'])) {
		    $value = $this->_x->textContent(self::$_systemAttributes[$prop]['xpath'], $this->_node, true);
		}
                // Otherwise, us a specified constant
		elseif (isset(self::$_systemAttributes[$prop]['constant'])) {
		    $value = self::$_systemAttributes[$prop]['constant'];
		}
                // Potentially post-process results as appropriate
		if (isset(self::$_systemAttributes[$prop]['convert'])) {
		    switch (self::$_systemAttributes[$prop]['convert']) {
		    case 'boolean':
			$value = ($value == 'true') ? true : false;
		    break;
                    case 'anonymous':
                        $value = ($value == XN_AtomHelper::XN_ANONYMOUS) ? null : $value;
		    default:
			break;
		    }
		}
		return $value;
            } else {
                throw new XN_IllegalArgumentException("Unknown property name: '".$prop."'");
            }
        }
    }

    /**
     * Set an attribute with default type
     *
     * @param $prop string attribute to set
     * @param $value mixed value to set
     */
    public function __set($prop, $value) {
        /* Developer attribute or system attribute? */
	$_bc_array_of_numbers_check = false;
	if (strpos($prop, 'my:') === 0) {
	    if (is_array($value)) {
		$type = 'string';
		$_bc_array_of_numbers_check = true;
	    } else {
		$type = (is_float($value) || is_int($value)) ? 'number' : 'string';
                if (is_bool($value)) {
                    $_bc_array_of_numbers_check = true;
                }
	    }
	}
        else {
	    $type ='string';
	}
	return $this->_setWithType($prop, $value, $type, true, $_bc_array_of_numbers_check);
    }

    /** @unsupported @internal
     * This function does all the actual work of setting property, taking care of
     * single vs. multivalued attributes, overwriting values vs. adding values,
     * and maintaining backwards compatibility
     */
    protected function _setWithType($name, $value, $type, $overwrite = false,
				    $_bc_array_of_numbers_check = false) {
        $nameToCheck = (strncmp('my:', $name, 3) == 0) ? substr($name, 3) : $name;
        if (XN_Attribute::_isClownString($nameToCheck)) {
            throw new XN_Exception("Invalid attribute name: $nameToCheck. Only letters, digits, and _ allowed.");
        }
        
	// Translate from any exposed-to-user types to used-in-XML types
	if ($type == XN_Attribute::CONTENT) {
	    $type = XN_Attribute::REFERENCE;
	}
        else if ($type == XN_Attribute::URL) {
            $type = XN_Attribute::STRING;
        }

	/* If there's not already an entry in the values-at-load array,
	 * set one */
	if (! array_key_exists($name, $this->_valuesAtLoad)) {
	  $x = $this->$name;
	  $this->_valuesAtLoad[$name] = $x;
	}
 

        /* Developer attribute or system attribute? */
        if (strpos($name, 'my:') === 0) {
            
            // A null value means "remove this attribute"
            if (is_null($value)) {
                return $this->remove($name);
            }

	    if ($overwrite) {
		$nodes = $this->_xquery($name);
		foreach ($nodes as $node) {
		    $node->parentNode->removeChild($node);
		}
		$nodeToUse = null;
	    }
	    // If we're not overwriting and a node already exists for this attribute,
	    // then:
	    // - if there's only one value in the doc for the attribute, convert it to use xn:value syntax
	    // - if there's only one value provided to set, convert $value to an array
	    else {
		$nodes = $this->_xquery($name);
		if ($nodes->length == 1) {
		    $valueNodes = $this->_xquery("$name/xn:value");
		    if ($valueNodes->length == 0) {
			$existingValue = $nodes->item(0)->textContent;
			foreach ($nodes->item(0)->childNodes as $childNode) {
			    $nodes->item(0)->removeChild($childNode);
			}
			$nodes->item(0)->appendChild($this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_XN,
                                                                                                  'xn:value', self::_valueToAtom($existingValue, $type)));
		    }
		}
		$nodeToUse = $nodes->item(0);
		if (! is_array($value)) {
		    $value = array($value);
		}
	    }
            
            // If we are overwriting and $value is an array but there's only one element in it,
            // convert $value from an array to a a scalar so that the attribute is not treated
            // as multivalued
            if ($overwrite && is_array($value)) {
                if (count($value) == 1) {
                    $value = $value[0];
                }
                else if (count($value) == 0) {
                    $value = null;
                }
            }

            if (is_array($value)) {
					// Save in _bc_unsavedTypes, but...
					if (($type == 'number') || $_bc_array_of_numbers_check) {
					    $this->_bc_unsavedTypes[$name] = gettype($value[0]);
					}
					if (! $nodeToUse) {
					    $nodeToUse = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_APP(XN_Application::load()->relativeUrl),
			                                                     $name);

					    // xn:type on type=xn_uploadedfile causes a 400
					    if ($type == 'xn_uploadedfile') {
						$nodeToUse->setAttribute('type', $type);
					    } else {
						$nodeToUse->setAttributeNS(XN_AtomHelper::NS_XN, 'xn:type', $type);
					    }
					    $this->_node->appendChild($nodeToUse);
					}
					foreach ($value as $v) {
					    $valueNode = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_XN, 'xn:value', self::_valueToAtom($v, $type));
					    $nodeToUse->appendChild($valueNode);
					}

            } else {
                if ($type == 'number' || $_bc_array_of_numbers_check) {
                    $this->_bc_unsavedTypes[$name] = gettype($value);
                }
		// Coerce objects, etc to strings if they sneak through from __set()
                $valueToSet = self::_valueToAtom($value, $type);
				$node = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_APP(XN_Application::load()->relativeUrl),
		                                                                     $name, $valueToSet);
				// xn:type on type=xn_uploadedfile causes a 400
				if ($type == 'xn_uploadedfile') {
				    $node->setAttribute('type', $type);
				} else {
				    $node->setAttributeNS(XN_AtomHelper::NS_XN, 'xn:type', $type);
				}
		     	foreach ($this->_node->childNodes as $child) {
		             if ($child->nodeName == $node->nodeName)
					 {
					 	 $this->_node->removeChild($child);
					 } 
		        }
                $this->_node->appendChild($node);
            }
        }
        else {
            if (isset(self::$_systemAttributes[$name])) {
                if (isset(self::$_systemAttributes[$name]['write']) && self::$_systemAttributes[$name]['write']) {
		    $createdNode = false;
		    if (isset(self::$_systemAttributes[$name]['callback'])) {
			$node = call_user_func(array($this,self::$_systemAttributes[$name]['callback']), 'write', $name, $value, $type, $overwrite);
		    } else {
			$nodeList = $this->_xquery(self::$_systemAttributes[$name]['xpath']);
			if (isset(self::$_systemAttributes[$name]['convert'])) {
			    switch (self::$_systemAttributes[$name]['convert']) {
			    case 'boolean':
                                $type = XN_Attribute::BOOLEAN;
				break;
			    default:
				break;
			    }
			}
			if ($nodeList->length == 0) {
			    // If the content object doesn't already have a title or description, 
			    // add it. 
                            if (! is_null($value)) {
                                if ($name == 'title') {
                                    $node = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_ATOM,
                                                                                         'atom:title', self::_valueToAtom($value));
                                } elseif ($name == 'description') {
                                    $node = $this->_node->ownerDocument->createElementNS(XN_AtomHelper::NS_ATOM,
                                                                                         'atom:summary', self::_valueToAtom($value));
                                } else {
                                    throw new XN_IllegalArgumentException("Unknown missing system attribute: $name");
                                }
                                $this->_node->appendChild($node);
                            }
			    $createdNode = true;
			}
			// Node is already there, replace its contents
			else {
			    $node = $nodeList->item(0);
			}
			if (! $createdNode) {
                            self::_setNodeValue($node, $value, $type);
                        }
		    }
                } else {
                    throw new XN_IllegalArgumentException("Attempted to set read-only system property '".$name."'");
                }
            } else {
                throw new XN_IllegalArgumentException("Attempted to set unknown system property '".$name."'");
            }
        }
	return $this;
    }

    /** @unsupported @internal */
    public function __sleep() {
        // saveXml($node) doesn't necessarily include all the parent namespaces,
        // so they must be explicitly added here
        $this->_node->setAttribute('xmlns', XN_AtomHelper::NS_ATOM);
        $this->_node->setAttribute('xmlns:xn', XN_AtomHelper::NS_XN);
        $this->_node->setAttribute('xmlns:my', XN_AtomHelper::NS_APP($this->ownerUrl));
	// The first element in the array is the serialization format version number
	$this->_serializationData = array(1, $this->_node->ownerDocument->saveXml($this->_node));
        return array('_serializationData');
    }

    /** @unsupported @internal */
    public function __wakeup() {
	if (! (is_array($this->_serializationData) && isset($this->_serializationData[0]))) {
	    throw new XN_SerializationException("Unspecified serialization version");
	}
	if ($this->_serializationData[0] == 1) {
            $this->_buildFromXml($this->_serializationData[1]);
	    $this->_serializationData = null;
	    XN_Cache::_put($this);
	} 
	else {
	    throw new XN_SerializationException("Unknown serialization version: {$this->_serializationData[0]}");
	}
    }
    
    /* Ye-olde transformers below */


    /**
     * An alias for the {@link XN_Content::htmlentities} method that 
     * returns the htmlentities values of the attributes or property of the 
     * given name, or of all system and developer attributes if no name is 
     * given.
     * 
     * @see htmlentities
     */
    public function h($name = null, $returnArray = false) {
        return $this->htmlentities($name, $returnArray);
    }
    /**
     * Returns the htmlentities values of the attributes or property of the 
     * given name, or of all system and developer attributes if no name is 
     * given.
     * 
     * Note that if the given name identifies a compound property type, it is 
     * returned untransformed as htmlentities is a scalar transformer. 
     * 
     * <code> 
     * // Get the htmlentities values of the 'review' developer attributes
     * $title = $content->my->htmlentities('review');
     * // Get the htmlentities value of the 'title' system attribute
     * $title = $content->htmlentities('title');
     * </code>
     * 
     * Refer to the XN_Content::raw accessor for a description of the accessor 
     * arguments and structure of returned values.
     *   
     * @param $name string attribute
     * @param $returnArray boolean true if an array is always to be returned.  
     * @return mixed the attribute value, an array, or null
     */
    public function htmlentities($name = null, $returnArray = false) {
        return $this->transform($name, 'xnhtmlentities', $returnArray);
    }
    /**
     * Returns the urlencoded values of the attributes or property of the 
     * given name, or of all system and developer attributes if no name is 
     * given.
     * 
     * <code> 
     * // Get the urlencoded values of the 'review' developer attributes
     * $title = $content->my->urlencode('review');
     * // Get the urlencoded value of the 'title' system attribute
     * $title = $content->urlencode('title');
     * </code>
     * 
     * Refer to the XN_Content::raw accessor for a description of the accessor 
     * arguments and structure of returned values.
     *   
     * @param $name string attribute
     * @param $returnArray boolean true if an array is always to be returned.  
     * @return mixed the attribute value, an array, or null
     */
    public function urlencode($name = null, $returnArray = false) {
        return $this->transform($name, 'urlencode', $returnArray);
    }
    /**
     * Returns the raw values of the attributes or property of the given name, 
     * or of all system and developer attributes if no name is given.
     * 
     * <code> 
     * // Get the raw values of the 'review' developer attributes
     * $title = $content->my->raw('review');
     * // Get the raw value of the 'title' system attribute
     * $title = $content->raw('title');
     * </code>
     * 
     * The structure of the returned values depends on the arguments given. If
     * a name is given and returnArray is defaulted, returns a single value if 
     * the name identifies a property or single attribute, a numerically 
     * indexed array of values if the name identifies multiple attributes, and
     * null if the name does not identify any attribute or property. If 
     * returnArray is true, returns a numerically indexed array of values or an
     * empty array if there are no values. If no name is given, returns a name 
     * indexed array of numerically indexed arrays of values. 
     *  
     * @param $name string attribute name
     * @param $returnArray boolean true if an array is always to be returned.  
     * @return mixed the attribute value, an array, or null
     */
    public function raw($name = null, $returnArray = false) {
        return $this->transform($name, null, $returnArray);
    }

    /** Returns the value of the specified attributes when the content
     * object was loaded. Useful for determining if attributes have changed
     * since the object was loaded
     * 
     * @param $name string attribute name
     * @param $returnArray boolean true if an array is always to be returned
     * @return mixed the attribute value, an array, or null
     */
    public function asLoaded($name = null, $returnArray = false) {
      /* If just system attributes are asked for, provide the ones
       * that could change */
      if (is_null($name)) {
	$ar = array();
	foreach (array('title','description','isPrivate') as $k) {
	  $a = $this->attribute($k, false);
	  $ar[$k] = array_key_exists($k, $this->_valuesAtLoad) ?
	    $this->_valuesAtLoad[$k] :
	    $this->attribute($k, false)->value;
	}
	return $ar;
      }
      /* If all developer attributes are asked for, */
      else if ($name == 'my:') {
	/* Provide the ones that have changed */
	foreach ($this->_valuesAtLoad as $k => $v) {
	  if (substr($k,0,3) == 'my:') {
	    $ar[substr($k,3)] = $v;
	  }
	}
	/* As well as the original values for any that haven't changed */
	foreach ($this->attribute($name) as $k => $v) {
	  if (! array_key_exists($k, $ar)) {
	    $ar[$k] = $this->my->$k;
	  }
	}
	return $ar;
      }
      /* And if a specific one is asked for, */
      else {
	/* Provide the original value if it's changed */
	if (array_key_exists($name, $this->_valuesAtLoad)) {
	  $val =  $this->_valuesAtLoad[$name];
	}
	/* Or the current value if it hasn't. */
	else {
	  $val = $this->$name;
	}
	return $returnArray ? array($val) : $val;
      }
      
    }

    /**
     * Returns the {@link XN_Attribute} objects of the attributes of the given 
     * name, or of all attributes if no name is given.
     * 
     * <code> 
     * // Get the XN_Attributes of the 'day' attributes. Force a return array.
     * $days = $content->my->attribute('day', true);
     * foreach($days as $day){
     *     print "<br/>'day' XN_Attribute = ".$day->debugString();
     * }
     * </code>
     * 
     * An XN_Attribute of a XN_Content property has a 
     * null id and has a type of 'object' or 'array' for compound property 
     * types.
     *    
     * Refer to the raw accessor for a description of the accessor 
     * arguments and structure of returned values.
     *   
     * @param $name string attribute name
     * @param $returnArray boolean true if an array is always to be returned.  
     * @return mixed the XN_Attribute, an array, or null
     */
    public function attribute($name = null, $returnArray = false) {
        if (is_null($name)||($name == 'my:')) { $returnArray = true; } // for BC
        return $this->_transformNode($name, array($this, '_attributeTransformer'), $returnArray);
    }
    /**
     * Returns the image dimensions of files in the content repository.
     * 
     * Returns the image dimensions of files referenced by 
     * {@link XN_Attribute::FILEIMAGE} attributes of the given name, or 
     * referenced by all {@link XN_Attribute::FILEIMAGE}
     * attributes if no name is given. Dimensions are returned as a two
     * element array where the first element is the width and the second
     * element is the height.
     * 
     * <code> 
     * // Get the image dimensions of the single attribute 'my->foo'. 
     * $dimensions = $content->my->imageDimensions('foo');
     * $width = $dimensions[0];
     * $height = $dimensions[1];
     * </code>
     * 
     * Refer to the raw accessor for a description of the structure of 
     * returned values. 
     * 
     * @param $name string attribute name
     * @param $array boolean true if an array is always to be returned
     * @return mixed an array or null
     */
    public function imageDimensions($name = null, $returnArray = false) {
        // @bc-check reloadifrequired
        return $this->_transformNode($name, array($this,'_imageDimensionsTransformer'), $returnArray);
    }
    /**
     * Returns the contents of files in the content repository.
     * 
     * Returns the contents of files referenced by 
     * {@link XN_Attribute::FILEIMAGE} attributes of the given name.
     * 
     * <code> 
     * // Get the contents of the single attribute 'my->foo'. 
     * $contents = $content->my->fileContents('foo');
     * echo $contents;
     * </code>
     * 
     * Refer to the raw accessor for a description of the structure of 
     * returned values. 
     * 
     * @param $name string attribute name
     * @return string the contents or null
     */
    public function fileContents($name = null) {
        // @bc-check reloadifrequired
        return $this->_transformNode($name, array($this,'_fileContentsTransformer'), false);
    }
    /**
     * Returns the URL to a file in the content store.
     * 
     * Returns the URL to a files referenced by binary
     * attributes of the given name.
     * 
     * <code> 
     * // Get the url of the developer attribute 'picture'
     * $url = $content->my->fileUrl('picture');
     * echo '<a href="'.$url.'">Download</a>';
     * </code>
     * 
     * @param $name string attribute name
     * @return string the url or null
     */
    public function fileUrl($name = null) {
        // @bc-check reloadifrequired
        return $this->_transformNode($name, array($this,'_fileUrlTransformer'), false);
    }
    /**
     * Returns the ids of {@link XN_Content} objects referenced under the given
     * name, or the ids of all referenced XN_Content objects if no name is 
     * given.
     * 
     * <code> 
     * // Get ids of content referenced as 'foo'. Force a return array. 
     * $contentIds = $container->my->contentIds('foo', true);
     * foreach($contentIds as $contentId) {
     *     print $contentId;
     * }
     * </code>
     * 
     * Refer to the raw accessor for a description of the accessor 
     * arguments and structure of returned values. In particular, as implied 
     * by the raw accessor, returned numerically indexed arrays of 
     * content ids are ordered by most-to-least recently created content 
     * <i>reference</i>. 
     * 
     * Refer to the content method for retrieving the referenced
     * XN_Content objects by a variety of sort criteria.  
     * 
     * @param $name string content reference name
     * @param $returnArray boolean true if an array is always to be returned
     * @return mixed a string, an array, or null
     */
    public function contentId($name = null, $returnArray = false) {
        return $this->_transformNode($name, array($this,'_contentIdTransformer'), $returnArray);
    }
    /**
     * Returns the {@link XN_Content} objects that reference this content
     * object by the given name.
     * 
     * <code> 
     * // Get all contents that reference this content as 'foo'.
     * $referencers = $content->contentReferencer('foo', true);
     * foreach($referencers as $referencer) {
     *     print $referencer->debugHtml();
     * }
     * </code>
     * 
     * The return type depends on the optional returnArray argument. If 
     * returnArray is defaulted to false, returns a single content if there is
     * a single referencer, an array of contents ordered by most-to-least 
     * recently created content if there are many referencers, and null if 
     * there are no referencers. If returnArray is true, always returns an 
     * array of contents ordered by most-to-least recently created content or 
     * an empty array if there are no referencers.
     * 
     * Note that this is a convenience method that wraps a {@link XN_Query} 
     * query:
     * <code>
     * XN_Query::create('Content')
     *    ->filter( $name, '=', $this->id )
     *    ->order( 'createdDate', 'desc' )
     *    ->execute();
     * </code>
     * It is recommended that a {@link XN_Query query} be directly used if more
     * query constraints or ordering are required. 
     * 
     * @param $name string the name that this content is referenced by
     * @param $returnArray boolean true if an array is always to be returned.  
     * @return mixed a XN_Content, an array, or null
     */
    public function contentReferencer($name, $returnArray = false) {
        if (! strlen($this->id)) {
            throw new XN_IllegalStateException(
                "Attempted to find referencers to content not yet stored ".
                "in the database");
        }
        
        $contents = 
            XN_Query::create('Content')
            ->filter('owner', '=')
            ->filter( $name, '=', $this->id )
                ->order( 'createdDate', 'desc' )
                ->execute();
        $numresults = count($contents);
        if ($numresults==0){
            return $returnArray ? array() : null;
        }
        else if ($numresults==1){
            return $returnArray ? $contents : $contents[0];
        }
        else {
            return $contents;
        }
    }
    /**
     * Returns the {@link XN_Content} objects referenced under the given name, 
     * or all referenced XN_Content objects if no name is given.
     * 
     * <code> 
     * // Get all contents referenced as 'foo'. Force an array to always return 
     * $contents = $container->my->content('foo', true);
     * foreach($contents as $content) {
     *     print $content->debugHtml();
     * }
     * </code>
     * 
     * Refer to the raw accessor for a description of the structure of 
     * returned values with the following exception: by default, returned 
     * numerically indexed arrays of content objects are sorted by 
     * most-to-least recently created content object. Compare this with the
     * contentId method in which numerically indexed arrays of content
     * ids are sorted by most-least recently created content <i>reference</i>.
     * 
     * Note that this is a convenience method that wraps a call of  
     * contentId to obtain the referenced content ids followed by a 
     * XN_Query using an 'in' filter to retrieve the corresponding 
     * content objects using the given sort criteria. It is recommended that 
     * XN_Query be directly used if more query constraints or ordering
     * are required. 
     * 
     * @param $name string content reference name
     * @param $returnArray boolean true if an array is always to be returned
     * @param $sortField string the property or attribute to sort by
     * @param $descendingOrder boolean true if sort in descending order.
     * @param $sortType string specifies the type for sorting if the sortField
     * is a developer attribute. The supported sort types are 'string' and 
     * 'number'. The default sort type for sorting by attributes is 'string'
     * @return mixed the XN_Content, an array, or null
     */
    public function content($name = null, $returnArray = false, $sortField = 'createdDate',
                            $descendingOrder = true, $sortType = 'string') {
        if (strpos($name, 'my:') !== 0) {
            throw new XN_UnsupportedOperationException('content() is not supported for system attributes');
        }
        $contentIdsArray = $this->contentId($name, true);
        $order = $descendingOrder ? 'desc' : 'asc';
        if (!is_null($name)){
            if (count($contentIdsArray) == 0) {
                $contents = array();
            } else {
                $contents = XN_Query::create('Content')
		    ->filter('owner')
		    ->filter( 'id', 'in', $contentIdsArray )
		    ->order( $sortField, $order, $sortType )
		    ->execute();
            }
            if (count($contents)>1){
                return $contents;
            }
            else if (count($contents)==1){
                return $returnArray ? $contents : $contents[0];
            }
            else {
                return $returnArray ? array() : null;
            }
        }
        else {
            foreach($contentIdsArray as $name => $contentIds){
                $contentIdsArray[$name] = 
                    XN_Query::create('Content')
		    ->filter('owner')
		    ->filter( 'id', 'in', $contentIds )
		    ->order( $sortField, $order, $sortType )
		    ->execute();
            }            
            return $contentIdsArray;
        }
    }

    /**
     * Returns the values transformed by the given callback function of the 
     * attributes of the given name, or of all attributes if no name is given.
     * 
     * <code> 
     * // Get the rawurlencode values of the 'day' developer attributes
     * $days = $content->my->transform('day', 'rawurlencode', true);
     * // Get the rawurlencode value of the 'description' system attribute
     * $description = $content->transform('description', 'rawurlencode');
     * </code>
     * 
     * Refer to the XN_Content::raw accessor for a description of the return type.
     *   
     * @param $attr string attribute
     * @param $callback mixed the transformer callback function. This parameter
     * type is the same as the call_user_func() parameter type.
     * @param $returnArray boolean true if an array is always to be returned.  
     * @return mixed the attribute value, an array, or null
     */
    public function transform($name, $callback, $returnArray = false) {
        // null callback == raw transformer
        if ((! is_callable($callback, false, $callableName)) && (! is_null($callback))) {
            throw new XN_IllegalArgumentException("The callback function '$callableName' isn't callable.");
        }

        if ($name == 'my:') { $name = 'my:*'; }
        else if (is_null($name)) { $name = self::_getXpathForSystemAttributes(); }

        $values = $this->__get($name);
        if (! is_array($values)) {
            $values = array($values);
        }
        if (! is_null($callback)) {
            foreach ($values as $k => $v) {
                if (is_array($v)) {
                    // $name matched multiple attributes and one or more is
                    // multivalued
                    foreach ($v as $k2 => $v2) {
                        $values[$k][$k2] = call_user_func($callback, $v2);
                    }
                } else {
                    $values[$k] = call_user_func($callback, $v);
                }
            }
        }
        if ($returnArray) {
            return $values;
        }
        else {
            return (count($values) > 1) ? $values : $values[0];
        }
    }

    /** @unsupported @internal
     * Applies a callback to attribute nodes, not just values; for things that need
     * access to attribute name and/or type in addition to value */
    protected function _transformNode($name, $callback, $returnArray) {
        if ((! is_callable($callback, false, $callableName)) && (! is_null($callback))) {
            throw new XN_IllegalArgumentException("The callback function '$callableName' isn't callable.");
        }
	if ($name == 'data') { $name = 'atom:content'; }
	if ($name == 'my:') { $name = 'my:*'; }
        else if (is_null($name)) { $name = self::_getXpathForSystemAttributes(); }
        
	$nodes = $this->_xquery($name);
	if (! is_null($callback)) {
	    $nodes = call_user_func($callback, $nodes, $returnArray);
	}
        if (is_array($nodes)) {
            $ar = $nodes;
        } else {
            $ar = array();
            foreach ($nodes as $node) {
                $ar[] = $node;
            }
        }
	if ($returnArray) {
	    return $ar;
	} else {
            if (count($ar) > 1) {
                return $ar;
            } else {
                $first = reset($ar);
                return $first;
            }
	}
    }	
   
    /** @unsupported @internal */
    protected function _imageDimensionsTransformer($nodes, $returnArray) {
	if ($nodes->length > 1) {
	    throw new XN_Exception("imageDimensions() does not support multiple nodes");
	}
	$dim = null;
	if ($nodes->length) {
	    $node = $nodes->item(0);
	    if ($node->getAttributeNS(XN_AtomHelper::NS_XN, 'type') == XN_Attribute::REFERENCE) {
                // NING-7136: Handle a single value or multiple xn:value children
                $valueNodes = $node->getElementsByTagNameNS(XN_AtomHelper::NS_XN, 'value');
                if ($valueNodes->length == 0) {
                    $valueNodes = array($node);
                }
                $dimList = array();
                foreach ($valueNodes as $node) {
                    if ($this->ownerUrl == XN_Application::load()->relativeUrl) {
                        $c = XN_Content::_loadCached(trim($node->textContent));
                        $dim = array();
                        $dim[] = floatval($c->_x->textContent('xn:width', $c->_node, true));
                        $dim[] = floatval($c->_x->textContent('xn:height', $c->_node, true));
                    } else {
                        $rsp = XN_REST::get(XN_REST::urlsprintf(XN_AtomHelper::ENDPOINT_APP($this->ownerUrl).'/content(id=%s)', trim($node->textContent)));
                        $x = XN_AtomHelper::XPath($rsp);
                        $dim = array();
                        $dim[] = floatval($x->textContent('/atom:feed/atom:entry/xn:width', null, true));
                        $dim[] = floatval($x->textContent('/atom:feed/atom:entry/xn:height', null, true));
                    }
                    $dimList[] = $dim;
                }
                $dim = (count($dimList) == 1) ? $dimList[0] : $dimList;
 	    }
	    /* If we're asking for the dimensions of the image pointed to by the 'data'
	     * attribute of this content object, use the values provided by the core when
	     * the object is loaded, if they exist
	     */
	    else if (XN_AtomHelper::NS_ATOM.':content' == "{$node->namespaceURI}:{$node->localName}") {
		$url = $node->getAttribute('src');
		if (strlen($url)) {
		    $dim = array();
		    $dim[] = floatval($this->_x->textContent('xn:width', $this->_node, true));
		    $dim[] = floatval($this->_x->textContent('xn:height', $this->_node, true));
		}
	    }
	}
	// _transformNode() expects the return value to be an array
	return array($dim);

    }

    // @todo: refactor to remove duplication with _imageDimensionsTransformer
    /** @unsupported @internal */
    protected function _fileUrlTransformer($nodes, $returnArray) {
	if ($nodes->length > 1) {
	    throw new XN_Exception("fileUrl does not support multiple nodes");
	}
	$src = null;
	if ($nodes->length) {
	    $node = $nodes->item(0);
	    if ($node->getAttributeNS(XN_AtomHelper::NS_XN, 'type') == XN_Attribute::REFERENCE) {	
                // NING-7136: Handle a single value or multiple xn:value children
                $valueNodes = $node->getElementsByTagNameNS(XN_AtomHelper::NS_XN, 'value');
                if ($valueNodes->length == 0) {
                    $valueNodes = array($node);
                }
                $srcList = array();
                foreach ($valueNodes as $node) {
                    if ($this->ownerUrl == XN_Application::load()->relativeUrl) {
                        $c = XN_Content::_loadCached(trim($node->textContent));
                        $content = $c->_xquery('atom:content');
                        if ($content->length != 1) {
                            throw new XN_Exception("Expected 1, got {$content->length} content references.");
                        }
                        $src = $content->item(0)->getAttribute('src');
                        if (! strlen($src)) {
                            throw new XN_Exception("Missing content URL");
                        }
                        $srcList[] = $src;
                    } else {
                        $rsp = XN_REST::get(XN_REST::urlsprintf(XN_AtomHelper::ENDPOINT_APP($this->ownerUrl).'/content(id=%s)', trim($node->textContent)));
                        $x = XN_AtomHelper::XPath($rsp);
                        $content = $x->query('/atom:feed/atom:entry/atom:content');
                        if ($content->length != 1) {
                            throw new XN_Exception("Expected 1, got {$content->length} content references.");
                        }
                        $src = $content->item(0)->getAttribute('src');
                        if (! strlen($src)) {
                            throw new XN_Exception("Missing content URL");
                        }
                        $srcList[] = $src;
                    }
                }
                $src = (count($srcList) == 1) ? $srcList[0] : $srcList;
	    }
	    else if (XN_AtomHelper::NS_ATOM.':content' == "{$node->namespaceURI}:{$node->localName}") {
		$src = $node->getAttribute('src');
	    }
	}
	// _transformNodes() expects an array
	return array($src);
    }

    /** @unsupported @internal */
    protected function _fileContentsTransformer($nodes, $returnArray) {
	$urls = $this->_fileUrlTransformer($nodes, $returnArray);
	$contents = array();
        foreach ($urls as $url) {
            if (is_array($url)) {
                $contents[] = array_map('file_get_contents', $url);
            } else {
                $contents[] = file_get_contents($url);
            }
        }
        return $contents;
    }

    /** @unsupported @internal */
    protected function _contentIdTransformer($nodes, $returnArray) {
	$ar = array();
	foreach ($nodes as $i => $node) {
	    if ($node->getAttributeNS(XN_AtomHelper::NS_XN, 'type') == XN_Attribute::REFERENCE) {
		// Does the node have xn:value children?
		$xnValueNodes = $node->getElementsByTagNameNS(XN_AtomHelper::NS_XN, 'value');
		if ($xnValueNodes->length == 0) {
		    $ar[] = trim($node->textContent);
		}
		else {
		    foreach ($xnValueNodes as $xnValueNode) {
			$ar[] = trim($xnValueNode->textContent);
		    }
		}
	    }
	    else {
		$ar[] = null;
	    }
	}
	return $ar;
    }

    /** @unsupported @internal */
    protected function _attributeTransformer($nodes, $returnArray) {
	$ar = array();
	foreach ($nodes as $i => $node) {
	    $attr =  XN_Attribute::createFromNode($this, $node);
            if ((! $returnArray) && is_array($attr) && (count($attr) == 1)) {
                $ar[$attr[0]->name] = $attr[0];
            } else {
                $ar[$attr[0]->name] = $attr;
            }
	}
	return $ar;
    }

    /* Ye-olde deprecated attribute manipulators */


    /**
     * Adds attributes of the given name, values, and type.
     * 
     * The given value argument is either a string value to add a single 
     * attribute of the given name, or an array of string values to add 
     * multiple attributes of the given name.
     *  
     * The type argument must be one of the {@link XN_Attribute} type constants
     * and defaults to {@link XN_Attribute::STRING} if omitted.
     * 
     * @param $name string attribute name
     * @param $value mixed a string value or array of string values
     * @param $type string attribute type
     * @return XN_Content the XN_Content object
     */
    public function add($name, $value, $type = XN_Attribute::STRING) {
	if (! is_null($value)) {  // @bc-check: reloadifrequired?
	    $value = is_array($value) ? $value : array($value);
	    foreach ($value as $v) {
		$this->_setWithType($name, $v, $type, false);
	    }
	}
	return $this;
    }
    /**
     * Sets the attributes of the given name with the given values, and type if 
     * setting an attribute.
     *
     * The given value argument is either a string value to set a single 
     * attribute of the given name, an array of string values to set multiple 
     * attributes of the given name, or null to remove the attributes of the 
     * given name.
     *  
     * If the given name identifies a single attribute or modifiable property, 
     * the attribute and type are replaced with the given values and type. If 
     * the given name identifies multiple attributes, they are 
     * {@link XN_AttributeContainer::remove removed} and new attributes of the given name, values, and 
     * type are {@link XN_AttributeContainer::add added}. If no value argument is given, all 
     * attributes of the given name are {@link XN_AttributeContainer::remove removed}. 
     * 
     * The type argument must be one of the {@link XN_Attribute} type 
     * constants and defaults to {@link XN_Attribute::STRING} if omitted.
     *  
     * @param $name string attribute name
     * @param $value mixed a string value or array of string values or null
     * @param $type string type
     * @return XN_Content the XN_Content object
     */
    public function set($name, $value = null, $type = XN_Attribute::STRING) {
        // @bc-check reloadifrequired
	if (($type == XN_Attribute::CONTENT) && is_object($value)) {
	    $this->setContent($name, $value);
	} else {
	    $this->_setWithType($name, $value, $type, true);
	}
	return $this;
    }

    /**
     * Removes the attributes of the given name, or all attributes if no name 
     * is given.
     * 
     * @param $name string attribute name. 
     * @return XN_Content the XN_Content object
     */
    public function remove($name) {
        if (strncmp($name,'my:', 3) != 0) {
            throw new XN_IllegalArgumentException("Can't remove attribute $name");
        }
        if (XN_Attribute::_isClownString(substr($name, 3))) {
            throw new XN_IllegalArgumentException("Illegal attribute nme for remove: $name");
        }
	if ($name == 'my:') {
	    $expr = 'my:*';
	} else {
	    $expr = $name;
	}
	foreach ($this->_xquery($expr) as $node) {
	    $node->parentNode->removeChild($node);
	}
	return $this;
    }

    /**
     * Adds content references of the given name to reference the given 
     * content. 
     *
     * The content argument can be a XN_Content object, a string content id, or
     * an array of XN_Content objects or string content ids. 
     *  
     * A content reference is {@link XN_AttributeContainer::add added} as an attribute with the 
     * referenced content id as the value and {@link XN_Attribute::CONTENT} as 
     * the type.
     * 
     * @param $name string content reference name 
     * @param $content mixed a XN_Content object, or string content id, or an
     * array of XN_Content objects or string content ids
     * @return XN_Content the XN_Content object
     */
    public function addContent($name, $content) {
	// @bc-check reloadifrequired
	if (is_array($content)) {
	    $ids = array();
	    foreach ($content as $c) {
		$ids[] = is_object($c) ? $c->id : $c;
	    }
	}
	else {
	    $ids = is_object($content) ? $content->id : $content;
	}
	return $this->add($name, $ids, XN_Attribute::CONTENT);
    }

    /**
     * Sets content references of the given name to reference the given
     * content.
     * 
     * The content argument can be a XN_Content object, a string content id,
     * an array of XN_Content objects or string content ids, or null. 
     * 
     * If multiple content references of the given name exist, the existing 
     * content references are {@link XN_AttributeContainer::removeContent removed} and new content 
     * references to the given content are {@link XN_AttributeContainer::addContent added}. If no 
     * content references of the given name exists, new content reference to 
     * the given content are {@link XN_AttributeContainer::addContent added}. If no content argument 
     * is given, all content references of the given name are 
     * {@link XN_AttributeContainer::removeContent removed}.
     * 
     * @param $name string content reference name 
     * @param $content mixed a XN_Content object, or string content id, or an
     * array of XN_Content objects or string content ids, or null
     * @return XN_Content the XN_Content object
     */
    public function setContent($name, $content = null) {
	// @bc-check reloadifrequired
	$this->removeContent($name);
	if (! is_null($content)) {
	    $this->addContent($name, $content);
	}
	return $this;
    }

    /**
     * Removes all content references of the given name referencing the given
     * content, or all content references of the given name if no content is 
     * given, or all content references if no name is given.
     * 
     * @param $name string content reference name 
     * @param $content mixed a XN_Content object or string content id
     * @return XN_Content the XN_Content object
     */
    public function removeContent($name = null, $content = null) {

        if (is_null($name)) {
            throw new XN_IllegalArgumentException("Can't remove content from system attributes");
        }
        
        // All developer attributes?
        if ($name == 'my:') { $name = 'my:*'; }

	// Attributes of the given name that are type content
	if (is_null($content)) {
	    $expr = "{$name}[@xn:type='" . XN_Attribute::REFERENCE . "']";
	}
	// Attributes of the given name of type content with the given value
	else {
            $expr = "{$name}[@xn:type='". XN_Attribute::REFERENCE . 
                "' and text()='". $content . "'] | {$name}[@xn:type='" . 
                XN_Attribute::REFERENCE . "' and xn:value/text()='" . $content . "']";
	}
        // @bc-check reloadifrequired
	$nodes = $this->_xquery($expr);
	foreach ($nodes as $node) {
	    $node->parentNode->removeChild($node);
	}
	return $this;
    }


    /** @unsupported @internal Necessary for XN_Cache */
    public function _getId() { return $this->id; }
    /** @unsupported @internal Necessary for XN_Cache */
    public function _loadCached($id) {
	$c = XN_Cache::_get($id, 'XN_Content');
	if (! $c) {
	    $c = self::load($id);
	}
	return $c;
    }


    /** @unsupported @internal 
     * Create an entry containing @c \<content> with a POST
     * 
     * @param $node DOMNode for the to-be-converted uploaded file attribute
     * @param $anonymous Whether to save it as anonymous or not
     */
    protected function _convertUploadedFile($node, $anonymous) {
	// If the $node has <xn:value/> children, each of them need to be converted
	$valueNodes = $node->getElementsByTagNameNS(XN_AtomHelper::NS_XN, 'value');
	if ($valueNodes->length == 0) {
	    $valueNodes = array($node);
	}
	if ($anonymous) {
	    $author = XN_AtomHelper::XN_ANONYMOUS;
	} else {
	    $p = XN_Profile::current();
	    $author = $p->isLoggedIn() ? $p->screenName : XN_AtomHelper::XN_ANONYMOUS;
	}
	$private = $this->isPrivate ? 'true' : 'false';
	$ns_app = XN_AtomHelper::NS_APP($this->ownerUrl);
	foreach ($valueNodes as $valueNode) {
	    $value = trim($valueNode->textContent);
	    if (! $value) { continue; }
	    $type = self::_guessUploadedMimeType($value);
	    $xml = XN_REST::xmlsprintf(trim('
<entry xmlns="%s" xmlns:xn="%s" xmlns:my="%s">
 <id>0</id>
 <published>2006-03-10T12:34:45Z</published>
 <updated>2006-03-10T12:34:45Z</updated>
 <author><name>%s</name></author>
 <xn:type>%s</xn:type>
 <title type="text">%s</title>				   
 <xn:private>%s</xn:private>
 <content type="%s">%s</content>
</entry>'), XN_AtomHelper::NS_ATOM, XN_AtomHelper::NS_XN, $ns_app,
				       $author, $type, $value,
				       $private,
				       $type, $value);
	    $rsp = XN_REST::post('/content', $xml);
	    /* Since we've just created a resource, the response is a 201
	     * whose response body is a feed with 1 entry: the new content object
	     * with ID, created, updated, etc. */
	    $x = XN_AtomHelper::XPath($rsp);
	    $entry = $x->query('/atom:feed/atom:entry')->item(0);
	    // Set this $node's value to the xn:id from the atom entry
	    foreach ($valueNode->childNodes as $child) { $child->parentNode->removeChild($child); }
	    $new_id = self::_idFromAtomEntry($x, $entry);
	    $valueNode->appendChild($node->ownerDocument->createTextNode($new_id));
	}
	// clear out the old xn_uploadedfile attribute 
	$node->removeAttribute('type');
	$node->setAttributeNS(XN_AtomHelper::NS_XN, 'xn:type', XN_Attribute::REFERENCE);
    }

    /** @unsupported @internal */
    protected static function _guessUploadedMimeType($value) {
	$type = 'application/octet-stream';
        foreach ($_POST as $k => $v) {
            if (($v === $value) && isset($_POST["$k:type"])) {
                $type = $_POST["$k:type"];
                break; // Don't scan any more values
            }
        }
        return $type;
    }

    /** @unsupported @internal */
    protected function _convertValuesToType($node, $type) {
	$valueNodes = $node->getElementsByTagNameNS(XN_AtomHelper::NS_XN, 'value');
	if ($valueNodes->length == 0) {
	    $valueNodes = array($node);
	}
	foreach ($valueNodes as $valueNode) {
            $value = $valueNode->textContent;
            if (($type == XN_Attribute::BOOLEAN) && ($value !== 'true') && ($value !== 'false')) {
                $value = (boolean) $value;
            }
            self::_setNodeValue($valueNode, $value, $type);
        }
    }


    /** @unsupported @internal */
    protected static function _idFromAtomEntry(XN_XPathHelper $x, DomNode $node) {
	$xn_id = $x->textContent('xn:id', $node, true);
        if (strlen($xn_id)) {
            return $xn_id;
        }
        $id = $x->textContent('atom:id', $node, true);
        if (strlen($id)) {
            return ((integer) $id);
        }
        return null;
    }

    /** @unsupported @internal */
    protected function _setDataCallback($op, $name, $value, $type, $overwrite) {
       if ($type == XN_Attribute::UPLOADEDFILE) {
	    $mimeType = self::_guessUploadedMimeType($value);
	    $node = $this->_node->ownerDocument->createElement('content');
            // This sets the node value with appropriate entity 
            // escaping (NING-7160)
            self::_setNodeValue($node, $value, XN_Attribute::STRING);
	    $node->setAttribute('type',$mimeType);
	    $this->_node->appendChild($node);
	    /* If we've just set our data value from an uploaded file
	     * and our type is 'XN_Uploadedfile', reset the type to
	     * the client-supplied mime type of the uploaded file. This
	     * works around apps that incorrectly call set('data') directly
	     * instead of assigning the uploaded file as a developer attr.
	     */
	    if (strtolower($this->type) == 'xn_uploadedfile') {
                $typeNode = $this->_xquery(self::$_systemAttributes['type']['xpath'])->item(0);
                self::_setNodeValue($typeNode, $mimeType);
	    }
	}
	else {
	    throw new XN_IllegalArgumentException("System property data must be set to an uploaded file");
	}
    }

    /** @unsupported @internal */
    protected function _lazyLoadCallback($op, $name) {
	if ($op != 'read') {
	    throw new XN_Exception("_lazyLoadCallback must only be called for reads");
	}
	if (array_key_exists($name, $this->_lazyLoadedData)) {
	    return $this->_lazyLoadedData[$name];
	}
	switch ($name) {
        case 'id':
            $this->_lazyLoadedData[$name] = self::_idFromAtomEntry($this->_x,
                                                                   $this->_node);
            break;
	case 'contributor':
	    $this->_lazyLoadedData[$name] = XN_Profile::_get($this->contributorName);
	    break;
	case 'owner':
	    $this->_lazyLoadedData[$name] = XN_Application::load($this->ownerUrl);
	    break;
	case 'ownerName':
	    $this->_lazyLoadedData[$name] = $this->owner->name;
	    break;
	default:
	    throw new XN_IllegalArgumentException("Unknown lazy-load property: $name");
	}
	return $this->_lazyLoadedData[$name];
    }

    /** @unsupported @internal */
    protected static function _getXpathForSystemAttributes() {
        if (! strlen(self::$_xpathForSystemAttributes)) {
            $qnames = array();
            foreach (self::$_systemAttributes as $attr => $info) {
                if (isset($info['xpath']) && 
                    ((! isset($info['read'])) || ($info['read'] === true))) {
                    $qnames[] = $info['xpath'];
                }
            }
            self::$_xpathForSystemAttributes = implode('|', $qnames);
        }
        return self::$_xpathForSystemAttributes;
    }

    /** @unsupported @internal */
    protected static function _setNodeValue($node, $value, $type) {
        foreach ($node->childNodes as $child) {
            $node->removeChild($child);
        }
        // No need to encode entities, createTextNode does that for us
        $node->appendChild($node->ownerDocument->createTextNode(self::_valueToAtom($value, $type, false)));
        return $node;
    }

    /** @unsupported @internal */
    protected function _registerMyNamespace($ns = null) {
        if (! $this->_x->namespacePrefixIsRegistered('my')) {
            if (is_null($ns)) {
                $ns = $this->_node->getAttribute('xmlns:my');
                if ($ns == '') {
                    $app = $this->_x->textContent('xn:application',$this->_node, true);
                    if ($app == '') {
                        $app = XN_Application::load()->relativeUrl;
                    }
                    $ns = XN_AtomHelper::NS_APP($app);
                }
            }
            $this->_x->registerNamespace('my', $ns);
        }
    }

    /** @unsupported @internal */
    protected static function _valueToAtom($value, $type = XN_Attribute::STRING, $encode = true) {
        if ($type == XN_Attribute::STRING) {
            $value = (string) $value;
        }
        if (($type == XN_Attribute::BOOLEAN) && is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        if ($encode) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }

    /** @unsupported @internal */
    protected static function _valueFromAtom($value, $type) {
        if ($type == XN_Attribute::BOOLEAN) {
            switch ($value) {
            case 'true':
                $value = true;
                break;
            case 'false':
                $value = false;
                break;
            }
        }
        return $value;
    }

  }

/**
 * XN_AttributeContainer proxies methods over to the XN_Content object it belongs to.
 * It has a whitelist of methods it proxies and transforms the arguments to add "my:" to
 * any property name specifiers.
 *
 * @ingroup XN
 */
class XN_AttributeContainer {
    protected $___h;
    protected static $___map;
    protected static $___methods = array('h' => true, 'htmlentities' => true, 'urlencode' => true,
                                         'raw' => true, 'attribute' => true, 'imagedimensions' => true,
                                         'filecontents' => true, 'fileurl' => true, 'contentid' => true,
                                         'content' => true,
					 'add' => true, 'set' => true, 'remove' => true,
					 'addcontent' => true, 'setcontent' => true, 'removecontent' => true,
					 'asloaded' => true);
    public function __construct($content) { 
        $h = spl_object_hash($content);
        self::$___map[$h] = $content;
        $this->___h = $h;
    }

    public function __get($p) { return self::$___map[$this->___h]->__get("my:$p"); }
    public function __set($p, $v) { return self::$___map[$this->___h]->__set("my:$p", $v); }
    public function __call($method, $args) {
        if (isset(self::$___methods[strtolower($method)])) {
            $args[0] = 'my:' . $args[0];
            return call_user_func_array(array(self::$___map[$this->___h], $method), $args);
        }
        else {
	    throw new Exception("@todo: disallowed my-> methods ($method)");
        }
    }
    public function __sleep() {
        return array();
    }

    public function ___removeFromMap() {
        unset(self::$___map[$this->___h]);
    }
}

/** This class represents a name, value, type tuple associated with a {@link XN_Content content} object.
 *  
 * @ingroup XN
 */
class XN_Attribute {
    /** Identifies a string attribute type */
    const STRING = "string";
    /** Identifies a number attribute type */
    const NUMBER = "number";
    /** Identifies a url attribute type */
    const URL = "url";
    /** Identifies a date attribute type */
    const DATE = "date";
    /** Identifies a file image attribute type */
    const FILEIMAGE = "file.image";
    /** Identifies a content attribute type */
    const CONTENT = "xn_content";
    /** Identifies an uploaded file attribute type */
    const UPLOADEDFILE = 'xn_uploadedfile';
    /** Identifies a binary attribute type */
    const BINARY = 'xn_binary';
    /** Identifies a boolean attribute type */
    const BOOLEAN = 'boolean';

    /** Identifies a reference type */
    const REFERENCE = 'reference';

    /** The ID, synthetic and constructed */
    protected $_id = -1;
    /** Attribute name */
    public $name;
    /** Attribute value */
    public $value;
    /** Attribute type -- one of the class constants */
    public $type;

    /** For properly calculating name and type values for system attributes */
    protected static $_nodeNameToSystemAttributeMap = 
        array('xn:id' => array('type' => XN_Attribute::STRING,
                               'name' => 'id'),
              'xn:type' => array('type' => XN_Attribute::STRING,
                                 'name' => 'type'),
              'atom:published' => array('type' => XN_Attribute::DATE,
                                        'name' => 'createdDate'),
              'atom:updated' => array('type' => XN_Attribute::DATE,
                                      'name' => 'updatedDate'),
              'atom:title' => array('name' => 'title',
                                    'type' => XN_Attribute::STRING),
              'atom:summary' => array('name' => 'description',
                                      'type' => XN_Attribute::STRING),
              'atom:name' => array('name' => 'contributorName',
                                   'type' => XN_Attribute::STRING),
              'xn:application' => array('name' => 'ownerUrl',
                                        'type' => XN_Attribute::STRING),
              'xn:private' => array('name' => 'isPrivate',
                                    'type' => XN_Attribute::BOOLEAN)
              );

    /** @unsupported @internal */
    public static function createFromNode($content, DOMNode $node) {
        // If there's more than 1 xn:value child, then this is a multivalued attribute
        $attrs = array();
        $values = array();
        $valueChildren = $node->getElementsByTagNameNS(XN_AtomHelper::NS_XN, 'value');
        if ($valueChildren->length == 0) {
            $values[] = $node->textContent;
        } else {
            foreach ($valueChildren as $valueChild) {
                $values[] = $valueChild->textContent;
            }
        }
        
        if ($node->prefix == 'my') {
            $type = $node->getAttributeNS(XN_AtomHelper::NS_XN, 'type');
            
            // Expose atom "reference" type as "xn_content"
            if ($type == XN_Attribute::REFERENCE) {
                $type = XN_Attribute::CONTENT;
            }
            
            $name = $node->localName;
        }
        else {
            $pfx = $node->prefix ?$node->prefix : 'atom';
            $qname = $pfx. ':' . $node->localName;
            if (isset(self::$_nodeNameToSystemAttributeMap[$qname])) {
                $type = self::$_nodeNameToSystemAttributeMap[$qname]['type'];
                $name = self::$_nodeNameToSystemAttributeMap[$qname]['name'];
            } 
            else {
                throw new XN_Exception("Unknown attribute qname: $qname");
            }

            if ($type == XN_Attribute::BOOLEAN) {
                $values[0] = ($values[0] === 'true') ? true : false;
            }
        }

        
        foreach ($values as $value) {
            $attr = new XN_Attribute($name,
                                     $value,
                                     $type);
            if ($content->id) {
                $attr->_calculateID($content);
            }
            $attrs[] = $attr;
        }
	return $attrs;
    }

    /** @unsupported @internal
     * Anything but (Letter|_)(Letter|Digit|CombiningChar|Extender|_)* (from
     * http://www.w3.org/TR/REC-xml/#sec-common-syn) makes you a clown.
     *
     */
     const clownRegex = '@^(?:[\x{0041}-\x{005A}\x{0061}-\x{007A}\x{00C0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{00FF}\x{0100}-\x{0131}\x{0134}-\x{013E}\x{0141}-\x{0148}\x{014A}-\x{017E}\x{0180}-\x{01C3}\x{01CD}-\x{01F0}\x{01F4}-\x{01F5}\x{01FA}-\x{0217}\x{0250}-\x{02A8}\x{02BB}-\x{02C1}\x{0386}\x{0388}-\x{038A}\x{038C}\x{038E}-\x{03A1}\x{03A3}-\x{03CE}\x{03D0}-\x{03D6}\x{03DA}\x{03DC}\x{03DE}\x{03E0}\x{03E2}-\x{03F3}\x{0401}-\x{040C}\x{040E}-\x{044F}\x{0451}-\x{045C}\x{045E}-\x{0481}\x{0490}-\x{04C4}\x{04C7}-\x{04C8}\x{04CB}-\x{04CC}\x{04D0}-\x{04EB}\x{04EE}-\x{04F5}\x{04F8}-\x{04F9}\x{0531}-\x{0556}\x{0559}\x{0561}-\x{0586}\x{05D0}-\x{05EA}\x{05F0}-\x{05F2}\x{0621}-\x{063A}\x{0641}-\x{064A}\x{0671}-\x{06B7}\x{06BA}-\x{06BE}\x{06C0}-\x{06CE}\x{06D0}-\x{06D3}\x{06D5}\x{06E5}-\x{06E6}\x{0905}-\x{0939}\x{093D}\x{0958}-\x{0961}\x{0985}-\x{098C}\x{098F}-\x{0990}\x{0993}-\x{09A8}\x{09AA}-\x{09B0}\x{09B2}\x{09B6}-\x{09B9}\x{09DC}-\x{09DD}\x{09DF}-\x{09E1}\x{09F0}-\x{09F1}\x{0A05}-\x{0A0A}\x{0A0F}-\x{0A10}\x{0A13}-\x{0A28}\x{0A2A}-\x{0A30}\x{0A32}-\x{0A33}\x{0A35}-\x{0A36}\x{0A38}-\x{0A39}\x{0A59}-\x{0A5C}\x{0A5E}\x{0A72}-\x{0A74}\x{0A85}-\x{0A8B}\x{0A8D}\x{0A8F}-\x{0A91}\x{0A93}-\x{0AA8}\x{0AAA}-\x{0AB0}\x{0AB2}-\x{0AB3}\x{0AB5}-\x{0AB9}\x{0ABD}\x{0AE0}\x{0B05}-\x{0B0C}\x{0B0F}-\x{0B10}\x{0B13}-\x{0B28}\x{0B2A}-\x{0B30}\x{0B32}-\x{0B33}\x{0B36}-\x{0B39}\x{0B3D}\x{0B5C}-\x{0B5D}\x{0B5F}-\x{0B61}\x{0B85}-\x{0B8A}\x{0B8E}-\x{0B90}\x{0B92}-\x{0B95}\x{0B99}-\x{0B9A}\x{0B9C}\x{0B9E}-\x{0B9F}\x{0BA3}-\x{0BA4}\x{0BA8}-\x{0BAA}\x{0BAE}-\x{0BB5}\x{0BB7}-\x{0BB9}\x{0C05}-\x{0C0C}\x{0C0E}-\x{0C10}\x{0C12}-\x{0C28}\x{0C2A}-\x{0C33}\x{0C35}-\x{0C39}\x{0C60}-\x{0C61}\x{0C85}-\x{0C8C}\x{0C8E}-\x{0C90}\x{0C92}-\x{0CA8}\x{0CAA}-\x{0CB3}\x{0CB5}-\x{0CB9}\x{0CDE}\x{0CE0}-\x{0CE1}\x{0D05}-\x{0D0C}\x{0D0E}-\x{0D10}\x{0D12}-\x{0D28}\x{0D2A}-\x{0D39}\x{0D60}-\x{0D61}\x{0E01}-\x{0E2E}\x{0E30}\x{0E32}-\x{0E33}\x{0E40}-\x{0E45}\x{0E81}-\x{0E82}\x{0E84}\x{0E87}-\x{0E88}\x{0E8A}\x{0E8D}\x{0E94}-\x{0E97}\x{0E99}-\x{0E9F}\x{0EA1}-\x{0EA3}\x{0EA5}\x{0EA7}\x{0EAA}-\x{0EAB}\x{0EAD}-\x{0EAE}\x{0EB0}\x{0EB2}-\x{0EB3}\x{0EBD}\x{0EC0}-\x{0EC4}\x{0F40}-\x{0F47}\x{0F49}-\x{0F69}\x{10A0}-\x{10C5}\x{10D0}-\x{10F6}\x{1100}\x{1102}-\x{1103}\x{1105}-\x{1107}\x{1109}\x{110B}-\x{110C}\x{110E}-\x{1112}\x{113C}\x{113E}\x{1140}\x{114C}\x{114E}\x{1150}\x{1154}-\x{1155}\x{1159}\x{115F}-\x{1161}\x{1163}\x{1165}\x{1167}\x{1169}\x{116D}-\x{116E}\x{1172}-\x{1173}\x{1175}\x{119E}\x{11A8}\x{11AB}\x{11AE}-\x{11AF}\x{11B7}-\x{11B8}\x{11BA}\x{11BC}-\x{11C2}\x{11EB}\x{11F0}\x{11F9}\x{1E00}-\x{1E9B}\x{1EA0}-\x{1EF9}\x{1F00}-\x{1F15}\x{1F18}-\x{1F1D}\x{1F20}-\x{1F45}\x{1F48}-\x{1F4D}\x{1F50}-\x{1F57}\x{1F59}\x{1F5B}\x{1F5D}\x{1F5F}-\x{1F7D}\x{1F80}-\x{1FB4}\x{1FB6}-\x{1FBC}\x{1FBE}\x{1FC2}-\x{1FC4}\x{1FC6}-\x{1FCC}\x{1FD0}-\x{1FD3}\x{1FD6}-\x{1FDB}\x{1FE0}-\x{1FEC}\x{1FF2}-\x{1FF4}\x{1FF6}-\x{1FFC}\x{2126}\x{212A}-\x{212B}\x{212E}\x{2180}-\x{2182}\x{3041}-\x{3094}\x{30A1}-\x{30FA}\x{3105}-\x{312C}\x{AC00}-\x{D7A3}]|[\x{4E00}-\x{9FA5}\x{3007}\x{3021}-\x{3029}]|_)(?:[\x{0041}-\x{005A}\x{0061}-\x{007A}\x{00C0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{00FF}\x{0100}-\x{0131}\x{0134}-\x{013E}\x{0141}-\x{0148}\x{014A}-\x{017E}\x{0180}-\x{01C3}\x{01CD}-\x{01F0}\x{01F4}-\x{01F5}\x{01FA}-\x{0217}\x{0250}-\x{02A8}\x{02BB}-\x{02C1}\x{0386}\x{0388}-\x{038A}\x{038C}\x{038E}-\x{03A1}\x{03A3}-\x{03CE}\x{03D0}-\x{03D6}\x{03DA}\x{03DC}\x{03DE}\x{03E0}\x{03E2}-\x{03F3}\x{0401}-\x{040C}\x{040E}-\x{044F}\x{0451}-\x{045C}\x{045E}-\x{0481}\x{0490}-\x{04C4}\x{04C7}-\x{04C8}\x{04CB}-\x{04CC}\x{04D0}-\x{04EB}\x{04EE}-\x{04F5}\x{04F8}-\x{04F9}\x{0531}-\x{0556}\x{0559}\x{0561}-\x{0586}\x{05D0}-\x{05EA}\x{05F0}-\x{05F2}\x{0621}-\x{063A}\x{0641}-\x{064A}\x{0671}-\x{06B7}\x{06BA}-\x{06BE}\x{06C0}-\x{06CE}\x{06D0}-\x{06D3}\x{06D5}\x{06E5}-\x{06E6}\x{0905}-\x{0939}\x{093D}\x{0958}-\x{0961}\x{0985}-\x{098C}\x{098F}-\x{0990}\x{0993}-\x{09A8}\x{09AA}-\x{09B0}\x{09B2}\x{09B6}-\x{09B9}\x{09DC}-\x{09DD}\x{09DF}-\x{09E1}\x{09F0}-\x{09F1}\x{0A05}-\x{0A0A}\x{0A0F}-\x{0A10}\x{0A13}-\x{0A28}\x{0A2A}-\x{0A30}\x{0A32}-\x{0A33}\x{0A35}-\x{0A36}\x{0A38}-\x{0A39}\x{0A59}-\x{0A5C}\x{0A5E}\x{0A72}-\x{0A74}\x{0A85}-\x{0A8B}\x{0A8D}\x{0A8F}-\x{0A91}\x{0A93}-\x{0AA8}\x{0AAA}-\x{0AB0}\x{0AB2}-\x{0AB3}\x{0AB5}-\x{0AB9}\x{0ABD}\x{0AE0}\x{0B05}-\x{0B0C}\x{0B0F}-\x{0B10}\x{0B13}-\x{0B28}\x{0B2A}-\x{0B30}\x{0B32}-\x{0B33}\x{0B36}-\x{0B39}\x{0B3D}\x{0B5C}-\x{0B5D}\x{0B5F}-\x{0B61}\x{0B85}-\x{0B8A}\x{0B8E}-\x{0B90}\x{0B92}-\x{0B95}\x{0B99}-\x{0B9A}\x{0B9C}\x{0B9E}-\x{0B9F}\x{0BA3}-\x{0BA4}\x{0BA8}-\x{0BAA}\x{0BAE}-\x{0BB5}\x{0BB7}-\x{0BB9}\x{0C05}-\x{0C0C}\x{0C0E}-\x{0C10}\x{0C12}-\x{0C28}\x{0C2A}-\x{0C33}\x{0C35}-\x{0C39}\x{0C60}-\x{0C61}\x{0C85}-\x{0C8C}\x{0C8E}-\x{0C90}\x{0C92}-\x{0CA8}\x{0CAA}-\x{0CB3}\x{0CB5}-\x{0CB9}\x{0CDE}\x{0CE0}-\x{0CE1}\x{0D05}-\x{0D0C}\x{0D0E}-\x{0D10}\x{0D12}-\x{0D28}\x{0D2A}-\x{0D39}\x{0D60}-\x{0D61}\x{0E01}-\x{0E2E}\x{0E30}\x{0E32}-\x{0E33}\x{0E40}-\x{0E45}\x{0E81}-\x{0E82}\x{0E84}\x{0E87}-\x{0E88}\x{0E8A}\x{0E8D}\x{0E94}-\x{0E97}\x{0E99}-\x{0E9F}\x{0EA1}-\x{0EA3}\x{0EA5}\x{0EA7}\x{0EAA}-\x{0EAB}\x{0EAD}-\x{0EAE}\x{0EB0}\x{0EB2}-\x{0EB3}\x{0EBD}\x{0EC0}-\x{0EC4}\x{0F40}-\x{0F47}\x{0F49}-\x{0F69}\x{10A0}-\x{10C5}\x{10D0}-\x{10F6}\x{1100}\x{1102}-\x{1103}\x{1105}-\x{1107}\x{1109}\x{110B}-\x{110C}\x{110E}-\x{1112}\x{113C}\x{113E}\x{1140}\x{114C}\x{114E}\x{1150}\x{1154}-\x{1155}\x{1159}\x{115F}-\x{1161}\x{1163}\x{1165}\x{1167}\x{1169}\x{116D}-\x{116E}\x{1172}-\x{1173}\x{1175}\x{119E}\x{11A8}\x{11AB}\x{11AE}-\x{11AF}\x{11B7}-\x{11B8}\x{11BA}\x{11BC}-\x{11C2}\x{11EB}\x{11F0}\x{11F9}\x{1E00}-\x{1E9B}\x{1EA0}-\x{1EF9}\x{1F00}-\x{1F15}\x{1F18}-\x{1F1D}\x{1F20}-\x{1F45}\x{1F48}-\x{1F4D}\x{1F50}-\x{1F57}\x{1F59}\x{1F5B}\x{1F5D}\x{1F5F}-\x{1F7D}\x{1F80}-\x{1FB4}\x{1FB6}-\x{1FBC}\x{1FBE}\x{1FC2}-\x{1FC4}\x{1FC6}-\x{1FCC}\x{1FD0}-\x{1FD3}\x{1FD6}-\x{1FDB}\x{1FE0}-\x{1FEC}\x{1FF2}-\x{1FF4}\x{1FF6}-\x{1FFC}\x{2126}\x{212A}-\x{212B}\x{212E}\x{2180}-\x{2182}\x{3041}-\x{3094}\x{30A1}-\x{30FA}\x{3105}-\x{312C}\x{AC00}-\x{D7A3}]|[\x{4E00}-\x{9FA5}\x{3007}\x{3021}-\x{3029}]|[\x{0030}-\x{0039}\x{0660}-\x{0669}\x{06F0}-\x{06F9}\x{0966}-\x{096F}\x{09E6}-\x{09EF}\x{0A66}-\x{0A6F}\x{0AE6}-\x{0AEF}\x{0B66}-\x{0B6F}\x{0BE7}-\x{0BEF}\x{0C66}-\x{0C6F}\x{0CE6}-\x{0CEF}\x{0D66}-\x{0D6F}\x{0E50}-\x{0E59}\x{0ED0}-\x{0ED9}\x{0F20}-\x{0F29}]|[\x{0300}-\x{0345}\x{0360}-\x{0361}\x{0483}-\x{0486}\x{0591}-\x{05A1}\x{05A3}-\x{05B9}\x{05BB}-\x{05BD}\x{05BF}\x{05C1}-\x{05C2}\x{05C4}\x{064B}-\x{0652}\x{0670}\x{06D6}-\x{06DC}\x{06DD}-\x{06DF}\x{06E0}-\x{06E4}\x{06E7}-\x{06E8}\x{06EA}-\x{06ED}\x{0901}-\x{0903}\x{093C}\x{093E}-\x{094C}\x{094D}\x{0951}-\x{0954}\x{0962}-\x{0963}\x{0981}-\x{0983}\x{09BC}\x{09BE}\x{09BF}\x{09C0}-\x{09C4}\x{09C7}-\x{09C8}\x{09CB}-\x{09CD}\x{09D7}\x{09E2}-\x{09E3}\x{0A02}\x{0A3C}\x{0A3E}\x{0A3F}\x{0A40}-\x{0A42}\x{0A47}-\x{0A48}\x{0A4B}-\x{0A4D}\x{0A70}-\x{0A71}\x{0A81}-\x{0A83}\x{0ABC}\x{0ABE}-\x{0AC5}\x{0AC7}-\x{0AC9}\x{0ACB}-\x{0ACD}\x{0B01}-\x{0B03}\x{0B3C}\x{0B3E}-\x{0B43}\x{0B47}-\x{0B48}\x{0B4B}-\x{0B4D}\x{0B56}-\x{0B57}\x{0B82}-\x{0B83}\x{0BBE}-\x{0BC2}\x{0BC6}-\x{0BC8}\x{0BCA}-\x{0BCD}\x{0BD7}\x{0C01}-\x{0C03}\x{0C3E}-\x{0C44}\x{0C46}-\x{0C48}\x{0C4A}-\x{0C4D}\x{0C55}-\x{0C56}\x{0C82}-\x{0C83}\x{0CBE}-\x{0CC4}\x{0CC6}-\x{0CC8}\x{0CCA}-\x{0CCD}\x{0CD5}-\x{0CD6}\x{0D02}-\x{0D03}\x{0D3E}-\x{0D43}\x{0D46}-\x{0D48}\x{0D4A}-\x{0D4D}\x{0D57}\x{0E31}\x{0E34}-\x{0E3A}\x{0E47}-\x{0E4E}\x{0EB1}\x{0EB4}-\x{0EB9}\x{0EBB}-\x{0EBC}\x{0EC8}-\x{0ECD}\x{0F18}-\x{0F19}\x{0F35}|\x{0F37}\x{0F39}\x{0F3E}\x{0F3F}\x{0F71}-\x{0F84}\x{0F86}-\x{0F8B}\x{0F90}-\x{0F95}\x{0F97}\x{0F99}-\x{0FAD}\x{0FB1}-\x{0FB7}\x{0FB9}\x{20D0}-\x{20DC}\x{20E1}\x{302A}-\x{302F}\x{3099}\x{309A}]|[\x{00B7}\x{02D0}\x{02D1}\x{0387}\x{0640}\x{0E46}\x{0EC6}\x{3005}\x{3031}-\x{3035}\x{309D}-\x{309E}\x{30FC}-\x{30FE}]|_)*$@u';

     /**
     * Returns a string debug representation of the XN_Attribute object
     * @return string a debug string
     */
    public function debugString() {
        return "[".$this->_id."] ".$this->name . " : " . $this->value . 
               " : " . $this->type;
    }

    /**
     * Provides read-only access to the attribute 'id', i.e, $attribute->id. 
     * Returns the string id.
     * @param $name string must be 'id'
     * @return string the string id
     */
    public function __get($name) {
        if ($name != 'id') 
            throw new XN_IllegalArgumentException(
                "Unknown property [".$name."]");
        return intval($this->_id);
    }
    /** @unsupported @internal */
    function __set($name, $value) {
        if ($name == 'id') 
            throw new XN_IllegalArgumentException("Cannot set attribute id");
        else
            throw new XN_IllegalArgumentException(
                "Unknown property [".$name."]");        
    }

    //--- Package functions ---
    
    /** @unsupported @internal
     * This method must only be called by classes in the XN package 
     */
    protected function __construct($name, $value, $type = self::STRING, $prop = false) {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        if ($prop) $this->_id = null;
    }
    
    /** @unsupported @internal */
    function _calculateID(XN_Content $c) {
	static $seq = 0;
	$seq++;
        $id = $c->id . '-' . $this->name;
	$id .= '-'.$seq;
        $this->_id = $id;
    }
        
    
    /** @unsupported @internal
     * Clown strings have 'funny characters' in them
     */
    public static function _isClownString($name) {
        // First test against some common shorter patterns to speed things up
        if (preg_match('@^[a-zA-Z_][a-zA-Z0-9_]+$@u',$name)) { return false; }
        if (preg_match('@[ !\@#\$%\^&\*\(\)[]{};\':"<>,\./\?\\\-=\+]@u',$name)) { return true; }
        return ! preg_match(self::clownRegex, $name);
    }
    
}

 } /* class-exists */