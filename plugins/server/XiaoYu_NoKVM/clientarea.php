<?php

function ClientArea_LoginService($params){
    echo '<form action="http://'.$params['server']['serverip'].'/vpsadm/login.asp" method="GET"><input type="hidden" name="vpsname" value="'.$params['service']['username'].'"><input type="hidden" name="vpspassword" value="'.$params['service']['password'].'"><button type="submit">点击前往</button></form>';
}

?>