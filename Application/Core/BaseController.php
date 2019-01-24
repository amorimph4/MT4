<?php

namespace Core {

    abstract class BaseController
    {

        /**
         * @access protected
         * @name $view
         * @var Objeto $view Armazena objeto da classe.
         */
        protected $view;
        /**
         * @access private
         * @name $viewPath
         * @var String $viewPath Armazena caminho da view.
         */
        
        private $viewPath;
        /**
         * @access private
         * @name $layoutPath
         * @var String $view Armazena layout a ser exibido Defult Null.
         */
        private $layoutPath;
        /**
         * @access private
         * @name $pageTitle
         * @var String $pageTitle Armazena título a ser exibido na vizualização do documento web.
         */
        private $pageTitle;
        /**
         * Construtor para requisição.
         * @param Construção Anonima.
         * @example example.php 20 1 __construct
         * @return Translator
         */
        public function __construct()
        {
            $this->view = new \stdClass;
        }

        protected function renderView($viewPath, $layoutPath = null)
        {
            $this->viewPath = $viewPath;
            $this->layoutPath = $layoutPath;
            if($layoutPath)
            {
                $this->layout();
            }
            else
            {
                $this->content();
            }
        }

        protected function content()
        {
            $path = __DIR__."/../App/Views/{$this->viewPath}.phtml";

            if(file_exists($path))
            {
                require_once $path;
            }
            else
            {
                echo "Error:view not found";
            }
        }

        protected function layout()
        {
            $path = __DIR__."/../App/Views/{$this->layoutPath}.phtml";

            if(file_exists($path))
            {
                require_once $path;
            }
            else
            {
                echo "Error:view not found";
            }
        }
    }
}