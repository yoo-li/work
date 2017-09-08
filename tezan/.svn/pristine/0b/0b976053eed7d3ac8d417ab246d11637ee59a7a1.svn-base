<?php

    class MetaField
    {
        private        $fieldId;
        private        $uitype;
        private        $blockId;
        private        $default;
        private        $tableName;
        private        $fieldName;
        private        $fieldLabel;
        private        $fieldType;
        private        $displayType;
        private        $mandatory;
        private        $tabid;
        private        $presence;
        private        $width;
        private        $align;
        private        $typeOfData;
        private        $fieldDataType;
        private static $tableMeta        = array ();
        private static $fieldTypeMapping = array ();
        private        $referenceList;
        private        $genericUIType    = 10;
        private        $relation;

        private function __construct($row)
        {
            $this->uitype      = $row['uitype'];
            $this->blockId     = $row['block'];
            $this->tableName   = $row['tablename'];
            $this->fieldName   = $row['fieldname'];
            $this->fieldLabel  = $row['fieldlabel'];
            $this->displayType = $row['displaytype'];
            $typeOfData        = $row['typeofdata'];
            $this->presence    = $row['presence'];
            $this->default     = $row['default'];
            $this->typeOfData  = $typeOfData;
            $typeOfData        = explode("~", $typeOfData);
            $this->mandatory   = ($typeOfData[1] == 'M') ? true : false;
            if ($this->uitype == '4')
            {
                $this->mandatory = false;
            }
            if ($this->uitype == '117')
            {
                $this->relation = $row['relation'];
            }
            $this->fieldType     = $typeOfData[0];
            $this->tabid         = $row['tabid'];
            $this->fieldId       = $row['fieldid'];
            $this->fieldDataType = null;
            $this->referenceList = null;
            if (isset($row['width']))
            {
                $this->width = $row['width'];
            }
            else
            {
                $this->width = 0;
            }
            if (isset($row['align']))
            {
                $this->align = $row['align'];
            }
            else
            {
                $this->align = 'left';
            }
        }

        public static function fromQueryResult($result)
        {
            $row                = array ();
            $row['uitype']      = $result->my->uitype;
            $row['block']       = $result->my->block;
            $row['tablename']   = $result->my->tablename;
            $row['fieldname']   = $result->my->fieldname;
            $row['fieldlabel']  = $result->my->fieldlabel;
            $row['displaytype'] = $result->my->displaytype;
            $row['typeofdata']  = $result->my->typeofdata;
            $row['presence']    = $result->my->presence;
            $row['tabid']       = $result->my->tabid;
            $row['fieldid']     = $result->my->fieldid;
            $row['default']     = $result->my->default;
            if (!is_null($result->my->width))
            {
                $row['width'] = $result->my->width;
            }
            else
            {
                $row['width'] = 0;
            }
            if (!is_null($result->my->align))
            {
                $row['align'] = $result->my->align;
            }
            else
            {
                $row['align'] = 'left';
            }
            if($result->my->uitype=='117'){
                $row['relation'] = $result->my->relation;
            }
            return new MetaField($row);
        }

        public static function fromArray($row)
        {
            return new MetaField($row);
        }

        public function getFieldName()
        {
            return $this->fieldName;
        }

        public function getTableName()
        {
            return $this->tableName;
        }

        public function getUIType()
        {
            return $this->uitype;
        }
        public function getrelationname()
        {
            return $this->relation;
        }
        public function getFieldDataType()
        {
            if ($this->fieldDataType === null)
            {
                $fieldDataType = $this->getFieldTypeFromUIType();
                if ($fieldDataType === null)
                {
                    $fieldDataType = $this->getFieldTypeFromTypeOfData();
                }
                if ($fieldDataType == 'date' || $fieldDataType == 'datetime' || $fieldDataType == 'time')
                {
                    $tableFieldDataType = $this->getFieldTypeFromTable();
                    if ($tableFieldDataType == 'datetime')
                    {
                        $fieldDataType = $tableFieldDataType;
                    }
                }
                $this->fieldDataType = $fieldDataType;
            }

            return $this->fieldDataType;
        }

        public function getTableFields()
        {
            $tableFields = null;
            if (isset(self::$tableMeta[$this->getTableName()]))
            {
                $tableFields = self::$tableMeta[$this->getTableName()];
            }
            else
            {
                $tableFields = array ();
                switch ($this->getTableName())
                {
                    case 'groups' :
                        $tableFields['id']          = array ('name' => 'id', 'type' => 'int', 'primary_key' => true, 'unique_key' => 0, 'not_null' => true);
                        $tableFields['groupname']   = array ('name' => 'groupname', 'type' => 'varchar', 'primary_key' => false, 'unique_key' => 1, 'not_null' => false);
                        $tableFields['description'] = array ('name' => 'description', 'type' => 'text', 'primary_key' => false, 'unique_key' => 0, 'not_null' => false);
                        break;
                    case 'attachmentsfolder' :
                        break;
                    default :
                        break;
                }
                self::$tableMeta[$this->getTableName()] = $tableFields;
            }

            return $tableFields;
        }

        public function getFieldId()
        {
            return $this->fieldId;
        }

        public function getWidth()
        {
            return $this->width;
        }

        public function getReferenceList()
        {
            static $referenceList = array ();
            if ($this->referenceList === null)
            {
                if (isset($referenceList[$this->getFieldId()]))
                {
                    $this->referenceList = $referenceList[$this->getFieldId()];

                    return $referenceList[$this->getFieldId()];
                }
                if (!isset(self::$fieldTypeMapping[$this->getUIType()]))
                {
                    $this->getFieldTypeFromUIType();
                }
                $fieldTypeData  = self::$fieldTypeMapping[$this->getUIType()];
                $referenceTypes = array ();
                if ($this->getUIType() != $this->genericUIType)
                {
                    $query = XN_Query::create('Content')->tag('Ws_referencetypes')
                        ->filter('type', 'eic', 'ws_referencetypes')
                        ->filter('my.fieldtypeid', '=', $fieldTypeData['fieldtypeid'])
                        ->execute();
                    foreach ($query as $query_info)
                    {
                        array_push($referenceTypes, $query_info->my->type);
                    }
                }
                else
                {
                    $query = XN_Query::create('Content')->tag('fieldmodulerels')
                        ->filter('type', 'eic', 'fieldmodulerels')
                        ->filter('my.fieldid', '=', $this->getFieldId())
                        ->execute();
                    foreach ($query as $query_info)
                    {
                        array_push($referenceTypes, $query_info->my->relmodule);
                    }
                }
                $referenceList[$this->getFieldId()] = $referenceTypes;
                $this->referenceList                = $referenceTypes;

                return $referenceTypes;
            }

            return $this->referenceList;
        }

        public function getFieldLabelKey()
        {
            return $this->fieldLabel;
        }

        public function getAlign()
        {
            return $this->align;
        }

        public function getFieldType()
        {
            return $this->fieldType;
        }

        private function getFieldTypeFromUIType()
        {
            if (empty(self::$fieldTypeMapping))
            {
                $tabsquery = XN_Query::create('Content')->tag('Ws_fieldtypes')
                    ->filter('type', 'eic', 'ws_fieldtypes')
                    ->execute();
                foreach ($tabsquery as $info)
                {
                    $ft                                        = array ();
                    $ft['fieldtypeid']                         = $info->id;
                    $ft['uitype']                              = $info->my->uitype;
                    $ft['fieldtype']                           = $info->my->fieldtype;
                    self::$fieldTypeMapping[$info->my->uitype] = $ft;
                }
            }
            if (isset(self::$fieldTypeMapping[$this->getUIType()]))
            {
                if (self::$fieldTypeMapping[$this->getUIType()] === false)
                {
                    return null;
                }
                $row = self::$fieldTypeMapping[$this->getUIType()];

                return $row['fieldtype'];
            }
            else
            {
                self::$fieldTypeMapping[$this->getUIType()] = false;

                return null;
            }
        }

        private function getFieldTypeFromTypeOfData()
        {
            switch ($this->fieldType)
            {
                case 'T':
                    return "time";
                case 'D':
                    return 'date';
                case 'DT':
                    return "datetime";
                case 'E':
                    return "email";
                case 'N':
                case 'NN':
                    return "double";
                case 'P':
                    return "password";
                case 'I':
                    return "integer";
                case 'V':
                default:
                    return "string";
            }
        }

        private function getFieldTypeFromTable()
        {
            $tableFields = $this->getTableFields();
            foreach ($tableFields as $fieldName => $dbField)
            {
                if (strcmp($fieldName, $this->getFieldName()) === 0)
                {
                    return $dbField->type;
                }
            }

            return null;
        }
    }