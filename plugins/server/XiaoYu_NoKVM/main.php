<?php

function XiaoYu_NoKVM_POSTDATA($params){
    $url = $params['url']."?". http_build_query($params['data']);
    $return = iconv("gb2312", "utf-8", file_get_contents($url));
    parse_str($return, $content);
    return $content;
}

function XiaoYu_NoKVM_ConfigOption(){
    return array(
        'productid' => array(
            'label' => '套餐ID',
            'placeholder' => '套餐ID',
            'type' => 'number',
        ),
        'idc' => array(
            'label' => '区域ID',
            'placeholder' => '区域ID',
            'type' => 'number',
        ),
        'fork' => array(
            'label' => '模板ID（操作系统）',
            'placeholder' => '模板ID（操作系统）',
            'type' => 'text',
        ),
    );
}

function XiaoYu_NoKVM_CreateService($params){
    $configoption = json_decode($params['product']['configoption'], true);
    $postdata = array(
        'url' => "http://".$params['server']['serverip']."/api/cloudapi.asp",
        'data' => array(
            'userid' => $configoption['fork'],
            'userstr' => md5($params['server']['serverpassword']."7i24.com"),
            'year' => $params['service']['time']['remark'],
            'vpsname' => $params['service']['username'],
            'VPSpassword' => $params['service']['password'],
            'idc' => $configoption['idc'],
            'productid' => $configoption['productid'],
            'action' => 'activate',
            'attach' => '云塔IDC系统开通云服务器',
        ),
    );
    $return = XiaoYu_NoKVM_POSTDATA($postdata);
    if($return['ret'] == "ok"){
        return array(
            'status' => 'success',
            'username' => $return['vpsname'],
            'password' => $params['service']['password'],
            'enddate' => date('Y-m-d', strtotime("+{$params['service']['time']['day']} days", time())),
            'configoption' => '',
        );
    }else{
        return array(
            'status' => 'fail',
            'msg' => $return['attach'],
        );
    }
}

function XiaoYu_NoKVM_RenewService($params){
    $postdata = array(
        'url' => "http://".$params['server']['serverip']."/api/cloudapi.asp",
        'data' => array(
            'userid' => $configoption['fork'],
            'userstr' => md5($params['server']['serverpassword']."7i24.com"),
            'year' => $params['data']['time']['remark'],
            'vpsname' => $params['service']['username'],
            'action' => 'renew',
            'attach' => '云塔IDC系统续费云服务器'
        ),
    );
    $return = XiaoYu_NoKVM_POSTDATA($postdata);
    if($return['ret'] == "ok"){
        return array(
            'status' => 'success',
            'enddate' => date('Y-m-d', strtotime("+{$params['data']['time']['day']} days", strtotime($params['service']['enddate']))),
        );
    }else{
        return array(
            'status' => 'fail',
            'msg' => $return['attach'],
        );
    }
}

function XioaYu_NoKVM_DeleteService($params){
    return array(
        'status' => 'success',
        'msg' => '删除必须在管理面板删除哦！',
    );
}

?>
