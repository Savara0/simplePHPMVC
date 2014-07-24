<?php
    require_once("dao/dao.php");

    function obtenerProductos($pageNum = 1, $pageItems=10){
        global $conn;
        $sqlstr = "Select * from productos limit %d, %d ;";
        return obtenerRegistros( $conn,
            sprintf($sqlstr, (($pageNum -1) * $pageItems), $pageItems)
                                );
    }
    function obtenerTotalProd(){
        global $conn;
        $sqlstr = "select count(*) as total from productos;";
        return obtenerRegistro($conn,$sqlstr)["total"];
    }
    function obtenerStockDisponible($idPrd){
        global $conn;
        $stockdisp = 0;
        $sqlstr = "select a.productoid, a.prodStock - ifnull(b.ctdCrt,0) as stockDisp,a.prodStock,ifnull(b.ctdCrt,0) as ctdCrt from productos a left join ( select productoid, count(*) as ctdCrt from carretilla_d group by productoid) b on a.productoid = b.productoid where a.productoid = %d;";
        $resultTmp  = obtenerRegistro($conn, sprintf(
                                $sqlstr, $idPrd));
        if(count($resultTmp)){
            $stockdisp = $resultTmp["stockDisp"];
        }
        return $stockdisp;
    }
?>