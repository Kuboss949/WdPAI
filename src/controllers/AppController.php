<?php
class AppController{

    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }


    protected function render(string $template = null, array $variables = []){
        $templatePath = 'src/views/'.$template.'.php';
        $output = 'File not found';
        if(file_exists($templatePath)){
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        //print $templatePath;
        print $output;
    }

    protected function layout(string $template = null, array $cssNames = [], array $jsNames = [], array $variables = []){
        $layoutPath = 'src/views/components/layout.php';
        $templatePath = 'src/views/'.$template.'.php';
        $output = 'File not found';
        if(file_exists($templatePath)){
            extract($variables);
            extract($cssNames);
            extract($jsNames);

            ob_start();
            include $layoutPath;
            $output = ob_get_clean();
        }
        print $output;
    }
}