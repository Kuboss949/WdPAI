<?php
class AppController{
    
    protected function render(string $template = null, array $cssNames = [], array $variables = []){
        $templatePath = 'src/views/'.$template.'.php';
        $output = 'File not found';
        if(file_exists($templatePath)){
            extract($variables);
            extract($cssNames);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        //print $templatePath;
        print $output;
    }

    protected function layout(string $template = null, array $cssNames = [], array $variables = []){
        $layoutPath = 'src/views/components/layout.php';
        $templatePath = 'src/views/'.$template.'.php';
        $output = 'File not found';
        if(file_exists($templatePath)){
            extract($variables);
            extract($cssNames);

            ob_start();
            include $layoutPath;
            $output = ob_get_clean();
        }
        print $output;
    }
}