<?php
    namespace Src\Controller\Configuration\Request;

    use Src\Controller\Request;

    class ConfigurationRequest extends Request
    {
        public $page_spec;

        public $update_order_spec;
        public $type_spec;
        public $scopes;
        public $category_spec;
        public $is_deleted = false;
        public $is_activated = true;
        public $created_timestamp_spec;
        public $last_updated_timestamp_spec;

        public $isAnd = true;
        public $isOr = false;

        public function __construct($arr)
        {
            $this->page_spec = PageSpecification($arr["page_spec"]);
            $this->update_order_spec = CriterSpecification($arr["update_order_spec"]);
            $this->type_spec = CriterSpecification($arr["type_spec"]);
            $this->scopes = $arr["scopes"];
            $this->category_spec = CriterSpecification($arr["category_spec"]);
            if ($arr["is_deleted"]) {
                $this->is_deleted = $arr["is_deleted"];
            }
            if ($arr["is_activated"]) {
                $this->is_activated = $arr["is_activated"];
            }
            $this->created_timestamp_spec = DateSpecification($arr["created_timestamp_spec"]);
            $this->last_updated_timestamp_spec = DateSpecification($arr["last_updated_timestamp_spec"]);
            if ($arr["isAnd"]) {
                $this->isAnd = $arr["isAnd"];
            }
            if ($arr["isOr"]) {
                $this->isOr = $arr["isOr"];
            }
        }
    }

