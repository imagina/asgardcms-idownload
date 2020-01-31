<?php
if (!function_exists('get_download')) {
    function get_download($options = array())
    {

        $default_options = array(
            'categories' => null,// categoria o categorias que desee llamar, se envia como arreglo ['categories'=>[1,2,3]]
            'users' => null, //usuario o usuarios que desea llamar, se envia como arreglo ['users'=>[1,2,3]]
            'include' => null,//id de post a para incluir en una consulta, se envia como arreglo ['id'=>[1,2,3]]
            'exclude' => null,// post, categorias o usuarios, que desee excluir de una consulta metodo de llmado category=>'', posts=>'' , users=>''
            'exclude_categories' => null,// categoria o categorias que desee Excluir, se envia como arreglo ['exclude_categories'=>[1,2,3]]
            'exclude_users' => null, //usuario o usuarios que desea Excluir, se envia como arreglo ['users'=>[1,2,3]]
            'date' => null, //['from'=>date('Y-m-d H:i:s'), 'to' => date('Y-m-d H:i:s')],
            'take' => 5, //Numero de posts a obtener,
            'skip' => 0, //Omitir Cuantos post a llamar
            'order' => ['field' => 'created_at', 'way' => 'desc'],//orden de llamado
        );

        $options = array_merge($default_options, $options);

        $download = app('Modules\Idownload\Repositories\DownloadRepository');
        $params = json_decode(json_encode(["filter" => $options, 'include' =>[],'take' => $options['take'], 'skip' => $options['skip']]));
        return $download->getItemsBy($params);
    }
}