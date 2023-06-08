<?php

class test{
    // REVIEW: コンソールにテスト出力
    function debug($data)
    {
        echo '<script>console.debug(' . json_encode($data) . ')</script>';
    }
    function error($data)
    {
        echo '<script>console.error(' . json_encode($data) . ')</script>';
    }
    function warn($data)
    {
        echo '<script>console.warn(' . json_encode($data) . ')</script>';
    }
    function info($data)
    {
        echo '<script>console.info(' . json_encode($data) . ')</script>';
    }

    function get($flg, $str)
    {
        if ($flg) {
            $this->warn("[NG]{$str}情報取得");
        } else {
            $this->info("[OK]{$str}情報取得");
        }
    }
}

?>