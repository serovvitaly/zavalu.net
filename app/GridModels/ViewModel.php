<?php

namespace App\GridModels;

class ViewModel
{
    protected $fields = [];

    protected $view = null;

    protected $wrapper = null;

    public static function make($items)
    {
        return '';
    }

    /**
     * @param null $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param null $view
     * @return $this
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    /**
     * @return string
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getFieldTitle($field_name)
    {
        $field_name = trim($field_name);

        $fields = $this->getFields();

        if ( ! array_key_exists($field_name, $fields) ) {
            return $field_name;
        }

        if ( ! array_key_exists('title', $fields[$field_name])) {
            return $field_name;
        }

        return $fields[$field_name]['title'];
    }

    public function getFieldWidget($field_name, $view = null)
    {
        $field_name = trim($field_name);

        $attributes = $this->getAttributes();

        if ( ! array_key_exists($field_name, $attributes) ) {
            return null;
        }

        if ( ! empty($view) ) {
            $this->setView($view);
        }

        $attribute_value = $attributes[$field_name];

        $fields = $this->getFields();

        if ( ! array_key_exists($field_name, $fields) or ! array_key_exists('widget', $fields[$field_name]) ) {

            $widget = [
                'grid' => 'text',
                'form' => 'input'
            ];

        } else {

            $widget = $fields[$field_name]['widget'];
        }

        if (is_array($widget)) {

            if ( ! array_key_exists($this->getView(), $widget) ) {

                return $attribute_value;
            }

            $widget = $widget[$this->getView()];
        }

        $widget = trim($widget);

        return view('grid.widget.' . $widget, ['model' => $this, 'name' => $field_name, 'value' => $attribute_value]);
    }
}
