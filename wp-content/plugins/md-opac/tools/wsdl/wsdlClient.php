<?php
class WsdlExceptionOpac extends Exception {

}

function numberView($id){
  try {
    $urlWsdl = get_option ( 'NumberViewPortWsdl', 'default_value' );
    if ( $urlWsdl=='default_value'){
      $result= -1;
    } else {
    $arrContextOptions=array("ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT));

    $options = array(
               'soap_version'=>SOAP_1_2,
               'exceptions'=>true,
               'trace'=>1,
               'cache_wsdl'=>WSDL_CACHE_NONE,
               'stream_context' => stream_context_create($arrContextOptions)
        );
      $gsearch = new SoapClient($urlWsdl, $options);
  
      $params = array(
          'idObject' => $id);
      $result = $gsearch->NumberViewOperation($params);
    }
  } catch (SoapFault $e) {
    throw new WsdlExceptionOpac('Riscontrato un errore nella verifica Software ['.$e->getMessage().']');
  }
  return $result;
}
?>
