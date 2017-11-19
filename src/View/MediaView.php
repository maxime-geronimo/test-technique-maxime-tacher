<?php

namespace App\View;

use Cake\View\View;

class MediaView extends View
{
    public function render($view = NULL, $layout = NULL) {
        $name = $download = $id = $modified = $path = $cache = $mimeType = $real_name = $compress = NULL;
        extract($this->viewVars, EXTR_OVERWRITE);

        $path = $path . $id;

        if (is_array($mimeType)) {
            $this->response->type($mimeType);
        }

        if ($cache) {
            if (!empty($modified) && !is_numeric($modified)) {
                $modified = strtotime($modified, time());
            } else {
                $modified = time();
            }
            $this->response->cache($modified, $cache);
        } else {
            $this->response->disableCache();
        }

        if ($name !== NULL) {
            $name .= '.' . pathinfo($id, PATHINFO_EXTENSION);
        }
        $this->response->file($path, [
            "download" => $download,
            "name" => $real_name
        ]);

        if ($compress) {
            $this->response->compress();
        }
    }
}