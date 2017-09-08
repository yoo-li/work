<?php
    require_once 'include/CRMEntity.php';
    require_once 'modules/CustomView/CustomView.php';

    class QueryGenerator
    {
        private $module;
        private $customViewColumnList;
        private $meta;
        private $user;
        private $fields;
        private $referenceModuleMetaInfo;
        private $moduleNameFields;
        private $referenceFieldInfoList;
        private $referenceFieldList;
        private $ownerFields;
        private $customViewFields;

        public function __construct($module, $user)
        {
            $this->module                    = $module;
            $this->customViewColumnList      = null;
            $this->user                      = $user;
            $this->fields                    = array ();
            $this->referenceModuleMetaInfo   = array ();
            $this->moduleNameFields          = array ();
            $this->meta                      = $this->getMeta($module);
            $this->moduleNameFields[$module] = $this->meta->getNameFields();
            $this->referenceFieldInfoList    = $this->meta->getReferenceFieldDetails();
            $this->referenceFieldList        = array_keys($this->referenceFieldInfoList);
            $this->ownerFields               = $this->meta->getOwnerFields();
            $this->customViewFields          = array ();
        }

        public function getMeta($module)
        {
            if (empty($this->referenceModuleMetaInfo[$module]))
            {
                $meta                                   = CRMEntityMeta::fromName($module, $this->user);
                $this->referenceModuleMetaInfo[$module] = $meta;
                if ($module == 'Users')
                {
                    $this->moduleNameFields[$module] = 'user_name';
                }
                else
                {
                    $this->moduleNameFields[$module] = $meta->getNameFields();
                }
            }

            return $this->referenceModuleMetaInfo[$module];
        }

        public function setFields($fields)
        {
            $this->fields = $fields;
        }

        public function getCustomViewFields()
        {
            return $this->customViewFields;
        }

        public function getFields()
        {
            return $this->fields;
        }

        public function getOwnerFieldList()
        {
            return $this->ownerFields;
        }

        public function getReferenceFieldList()
        {
            return $this->referenceFieldList;
        }

        public function getReferenceFieldInfoList()
        {
            return $this->referenceFieldInfoList;
        }

        public function getModule()
        {
            return $this->module;
        }

        public function initForDefaultCustomView($customView = null)
        {
            if (!$customView)
            {
                $customView = new CustomView($this->module);
            }
            $viewId = $customView->getViewId($this->module);
            $this->initForCustomViewById($viewId, $customView);
        }

        public function initForCustomViewById($viewId, $customView = null)
        {
            if (!$customView)
            {
                $customView = new CustomView($this->module);
            }
            $this->customViewColumnList = $customView->getColumnsListByCvid($viewId);
            if (!empty($this->customViewColumnList))
            {
                foreach ($this->customViewColumnList as $customViewColumnInfo)
                {
                    $this->fields[]           = $customViewColumnInfo;
                    $this->customViewFields[] = $customViewColumnInfo;
                }
            }
            if ($this->module == 'Calendar' && !in_array('activitytype', $this->fields))
            {
                $this->fields[] = 'activitytype';
            }
            if ($this->module == 'Documents')
            {
                if (in_array('filename', $this->fields))
                {
                    if (!in_array('filelocationtype', $this->fields))
                    {
                        $this->fields[] = 'filelocationtype';
                    }
                    if (!in_array('filestatus', $this->fields))
                    {
                        $this->fields[] = 'filestatus';
                    }
                }
            }
            $this->fields[] = 'id';
        }
    }