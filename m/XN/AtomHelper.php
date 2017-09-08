<?php
/** Utility classes for processing Atom feeds.
 *
 * @file
 * @ingroup XN
 */

/* $Revision$ */

/**
 * Helper class to provide common constants and Atom-related operations
 *
 * @ingroup XN
 */
class XN_AtomHelper {
    /** Atom namespace */
    const NS_ATOM = 'http://www.w3.org/2005/Atom';
    /** Atom Publishing Protocol namespace */
    const NS_ATOMPUB = 'http://www.w3.org/2007/app';
    /** Ning-wide namespace */
    const NS_XN   = 'http://www.ning.com/atom/1.0';
    /** Ning's email namespace */
    const NS_EMAIL   = 'http://www.ning.com/atom/1.0/profile/email';
    /** Constants to use in places where the client must supply a value but
      * the server ignores it */
    const XN_IG_ID = 'ignored-id';
    const XN_IG_AUTHOR = 'ignored-author-name';
    const XN_ANONYMOUS = 'xn_anonymous';
    /** URI Prefix for endpoint access within an app */
    const APP_ATOM_PREFIX = '/xn/rest/1.0';
    /** URI Prefix for global endpoint access */
    const XN_ATOM_PREFIX = '/atom/1.0';

    /** Individual classes' _fromAtomEntry() method can return this
     * to tell loadFromAtomFeed() to skip the entry */
    const IGNORE_ENTRY = 'ignore-entry';

    /** Endpoint ports to use. Set in _xn_prepend.php if server provides a value */
    public static $EXTERNAL_PORT = 80;
    public static $EXTERNAL_SSL_PORT = 443;
    /** Endpoint domain suffix to use. Set in _xn_prepend.php if server provides a value */
    public static $DOMAIN_SUFFIX = '.361crm.com';

    protected static function APP_ATOM_PREFIX_VERSION($version = '1.0') {
    return '/xn/rest/' . $version;
    }
    public static function APP_REST_PREFIX($version = '1.0') {
    return '/xn/rest/' . $version;
    }
    protected static function NS_XN_VERSION($version = '1.0') {
    return 'http://www.ning.com/atom/' . $version;
    }
    protected static function EMAIL_XN_VERSION($version = '1.0') {
    return 'http://www.ning.com/atom/' . $version . "/profile/email";
    }
    /** */
    public static function NS_APP($app) {
        return 'http://' . $app . self::$DOMAIN_SUFFIX . self::APP_ATOM_PREFIX;
    }
    public static function NS_APP_REST($app, $version = '2.0') {
    return 'http:// ' . $app . self::$DOMAIN_SUFFIX . self::APP_REST_PREFIX($version);
    }
    public static function ENDPOINT_APP($app, $version = '1.0') {
        return 'http://' . self::HOST_APP($app) . self::APP_ATOM_PREFIX_VERSION($version);
    }
    public static function ENDPOINT_APP_REST($app, $version = '2.0') {
        return 'http://' . self::HOST_APP($app) . self::APP_REST_PREFIX($version);
    }
    public static function ENDPOINT_XN() {
        return 'http://' . self::HOST_XN() . self::XN_ATOM_PREFIX;
    }
    public static function HOST_APP($app) {
        return $app . self::$DOMAIN_SUFFIX .
        ((self::$EXTERNAL_PORT != 80) ? ':'.self::$EXTERNAL_PORT : '');
    }
    public static function HOST_XN() {
        return 'api' . self::$DOMAIN_SUFFIX .
        ((self::$EXTERNAL_PORT != 80) ? ':'.self::$EXTERNAL_PORT : '');
    }

    public static function URL_TAGFEED($app, $resource, $id) {
        return self::ENDPOINT_APP($app) . '/'.urlencode($resource).'(id='.urlencode($id).')/tag';
    }
    public static function XPath($xml, $version = '1.0') {
        if (is_string($xml)) {
            $d = new DomDocument();
            $ok = @$d->loadXML($xml);
            if ($ok === false) {
                throw new XN_Exception("Can't parse XML response.");
            }
        } else {
            $d = $xml;
        }
        $x = new XN_XPathHelper($d);
        $x->registerNamespace('atom',self::NS_ATOM);
        $x->registerNamespace('atompub',self::NS_ATOMPUB);
        $x->registerNamespace('xn',self::NS_XN_VERSION($version));
        $x->registerNamespace('email',self::EMAIL_XN_VERSION($version));
        return $x;
    }

    public static function loadFromAtomFeed($xmlSource, $class, $singleResult = true, $cacheable = true,$datatype=0) {
        /** $xmlSource could be
        * - a string containing XML
        * - a DomDocument object
        * - an XN_XPathHelper object
        *
        * And what we want is an XN_XPathHelper object. So if we don't have one,
        * make it.
        */
        if ($xmlSource instanceof XN_XPathHelper) {
            $x = $xmlSource;
        } else if ($xmlSource instanceof DomDocument) {
            $x = XN_AtomHelper::XPath($xmlSource);
        } else {
            $tmp = new DomDocument();
            $tmp->loadXML($xmlSource);
            $x = XN_AtomHelper::XPath($tmp);
        }

        if ('XN_Content' == $class) {
            $entries = XN_Content::createMany($x,$datatype);
            if (count($entries) == 0) {
                return $singleResult ? null : array();
            }
        } else {
            // Tags are not represented by atom entries
            $expression = '/atom:feed/atom:entry';
            if ($class == 'XN_Tag') { $expression = '/atom:feed/xn:tag'; }
            if ($class == 'XN_ContactImportService') { $expression = '/atompub:service/atompub:workspace/atompub:collection'; }

            /* Initialize $entries so an array is returned even if nothing
             * is added to it (NING-10769) */
            $entries = array();
            $errorResult = $singleResult ? null : array();
            $entryNodes = $x->query($expression);
            // No results? Return null or an empty array
            if ($entryNodes->length == 0) {
                return $errorResult;
            }
            foreach ($entryNodes as $entryNode) {
                $obj = call_user_func(array($class,'_createEmpty'));
                $parsedOK = $obj->_fromAtomEntry($x, $entryNode);
                if ($parsedOK !== self::IGNORE_ENTRY) {
                    if ($cacheable) {
                        if ($parsedOK) {
                            $fromCache = XN_Cache::_get($obj->_getId(), $class);
                            if (is_null($fromCache)){
                                XN_Cache::_put($obj);
                                $entries[] = $obj;
                            } else {
                                $fromCache->_copy($obj);
                                $entries[] = $fromCache;
                            }
                        } else {
                            return $errorResult;
                        }
                    }
                    else {
                        $entries[] = $obj;
                    }
                }
            }
        }
        if ($singleResult) {
            if (count($entries) == 1) {
                return $entries[0];
            } else {
                throw new XN_Exception("Expected 1 result, but received ".count($entries));
            }
        } else {
            return $entries;
        }
    }

    public static function parseError($xml) {
        /*$errorInfo = array(-1, 'Unknown System Error'); // code, message
         @todo <xn:error/> in error responses
        $doc = new DomDocument();
        $doc->loadXML($xml);
        $error = $doc->getElementsByTagNameNS(XN_AtomHelper::NS_XN,'error');
        if (($error->length == 1) && (! is_null($code = XN_XPathHelper::attribute($error->item(0),'code')))) {
            $errorInfo[0] = $code;
            $errorInfo[1] = $error->item(0)->textContent;
        }
        */
        $errorInfo = array(null, $xml);
        return $errorInfo;
    }
}

class XN_XPathHelper extends DomXPath {
    protected $namespaces = array();

    public function textContent($q, $node = null, $optional = false) {
        $nodeList = is_null($node) ? $this->query($q) : $this->query($q, $node);
        if (($nodeList->length == 0) && $optional) {
            return null;
        }
        if ($nodeList->length != 1) {
            throw new XN_Exception("Expected 1 result, got {$nodeList->length} for XPath query {$q}");
        }
        return $nodeList->item(0)->textContent;
    }

    public static function attribute($node, $attribute) {
        $attr = $node->attributes->getNamedItem($attribute);
        return is_null($attr) ? null : $attr->textContent;
    }

    public function registerNamespace($prefix, $uri) {
        if (! (isset($this->namespaces[$prefix]) &&
        $this->namespaces[$prefix] == $uri)) {
            $this->namespaces[$prefix] = $uri;
            return parent::registerNamespace($prefix, $uri);
        }
    }

    public function namespacePrefixIsRegistered($prefix) {
        return isset($this->namespaces[$prefix]);
    }
}
