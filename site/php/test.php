<?php

class test{
    // REVIEW: コンソールにテスト出力
    function debug($data)
    {
        // デバッグ
        echo '<script>console.debug(' . json_encode($data) . ')</script>';
    }
    function error($data)
    {
        // 異常
        echo '<script>console.error(' . json_encode($data) . ')</script>';
    }
    function warn($data)
    {
        // 注意
        echo '<script>console.warn(' . json_encode($data) . ')</script>';
    }
    function info($data)
    {
        // 情報
        echo '<script>console.info(' . json_encode($data) . ')</script>';
    }

    // コンソール表示(取得成否)
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