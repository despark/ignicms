<?php

namespace Despark\Admin\Traits;

use Despark\Models\Entry;
use Illuminate\Support\Facades\Input;
use Despark\Admin\Helpers\FormBuilder;

/**
 * Class AdminConfigTrait.
 */
trait AdminConfigTrait
{
    /**
     * @array $adminColumns table columns in admin list page
     */
    public $adminColumns;

    /**
     * @array $filters filters at list page
     */
    public $adminFilters;

    /**
     * @var
     */
    public $adminFormFields;

    // Preview button show/hide
    /**
     * @var bool
     */
    public $adminPreviewMode = false;

    /**
     * @var string
     */
    public $adminPreviewUrlParams = [];

    /**
     * @return mixed
     */
    public function adminTableColumns()
    {
        return $this->adminColumns;
    }

    /**
     * Transform 1/0 or true/false into yes/no.
     *
     * @param $data
     *
     * @return string
     */
    public function yes_no($data)
    {
        return $data ? 'yes' : 'no';
    }

    /**
     * Format date - F jS, Y.
     *
     * @param $data
     *
     * @return string
     */
    public function formatDefaultData($data)
    {
        return date('F jS, Y', strtotime($data));
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function entityType($data)
    {
        switch ($data) {
            case Entry::ESTIMATE :
                return 'Project Estimate';
                break;
            case Entry::JOB_OFFER :
                return 'Job Offer';
                break;
            case Entry::SAY_HI :
                return 'Say "Hi"';
                break;
        }
    }

    /**
     * return model fields in proper way.
     *
     * @param $record
     * @param $col
     *
     * @return mixed
     */
    public function renderTableRow($record, $col)
    {
        switch (array_get($col, 'type', 'text')) {
            case 'yes_no':
                return $record->yes_no($record->$col['db_field']);
                break;
            case 'format_default_date':
                return $record->formatDefaultData($record->$col['db_field']);
                break;
            case 'entityType':
                return $record->entityType($record->$col['db_field']);
                break;
            case 'relation':
                return $record->yes_no($record->$col['db_field']);
                break;
            case 'sort':
                return '<div class="fa fa-sort sortable-handle"></div>';
                break;
            default :
                return $record->$col['db_field'];
                break;
        }
    }

    /**
     * combine all seach and filter functions into filtering.
     *
     * @return $this
     */
    public function filtering()
    {
        return $this->searchText();
    }

    /**
     * create query for list page.
     */
    public function searchText()
    {
        $query = $this->newQuery();
        if (Input::get('admin_text_search')) {
            foreach ($this->adminFilters['text_search']['db_fields'] as $field) {
                $query->orWhere($field, 'LIKE', '%'.Input::get('admin_text_search').'%');
            }
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function hasFilters()
    {
        return $this->adminFilters;
    }

    /**
     * @return bool
     */
    public function hasSearchTextFilter()
    {
        return $this->adminFilters['text_search'] and $this->adminFilters['text_search']['db_fields'];
    }

    /**
     * @return string
     */
    public function buildForm()
    {
        $formFields = '';

        foreach ($this->getFormFields() as $field => $options) {
            $formBuilder = new FormBuilder();
            $formFields .= $formBuilder->field($this, $field, $options);
        }

        return $formFields;
    }

    /**
     * @return mixed
     */
    public function getFormFields()
    {
        return $this->adminSetFormFields()->adminFormFields;
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return mixed
     */
    public function getRulesUpdate()
    {
        return (isset($this->rulesUpdate)) ? $this->rulesUpdate : $this->rules;
    }

    /**
     * Generate preview button for the CMS
     * $adminPreviewMode should be true.
     *
     *@return string
     */
    public function adminPreviewButton()
    {
        if ($this->adminPreviewMode and $this->exists) {
            $db_field = $this->adminPreviewUrlParams['db_field'];

            return \Html::link(
                route($this->adminPreviewUrlParams['route'], [$this->$db_field, 'preview_mode=1']),
                'Preview',
                ['class' => 'btn btn-primary', 'target' => '_blank']
            );
        }
    }
}
