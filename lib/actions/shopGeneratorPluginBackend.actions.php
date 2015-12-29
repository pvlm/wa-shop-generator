<?php

class shopGeneratorPluginBackendActions extends waViewActions
{
    /** @var string */
    protected $template_folder = 'templates/actions/backend/';

    /**
     * Страница настроек
     */
    public function setupAction()
    {
        $this->view->assign('categories', new shopCategories());
    }

    /**
     * @param string $type
     * @return string
     */
    protected function respondAs($type = NULL)
    {
        if ($type !== NULL) {
            if ($type == 'json') {
                $type = 'application/json';
            }
            $this->getResponse()->addHeader('Content-type', $type);
        }

        return $this->getResponse()->getHeader('Content-type');
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        $plugin_root = $this->getPluginRoot();

        if ($this->template === NULL) {
            if ($this->respondAs() === 'application/json') {
                return $plugin_root . 'templates/json.tpl';
            }
            $template = ucfirst($this->action);
        } else {
            if (strpbrk($this->template, '/:') !== FALSE) {
                return $this->template;
            }
            $template = $this->template;
        }

        return $plugin_root . $this->template_folder . $template . $this->view->getPostfix();
    }
}