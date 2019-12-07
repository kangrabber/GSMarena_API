<?php

// i hope you like it :)
// Created by Kangrabber !
error_reporting(0);
function grab($data){
    return str_replace(PHP_EOL,'',file_get_contents($data));
}

function gsmArena($data){
    $grab = grab($data);
    preg_match('/<title>(.*?) - Full phone specifications<\/title>/',$grab,$title);
    preg_match('/<meta name="Description" content="(.*?)">/',$grab,$description);
    preg_match('/<span data-spec="released-hl">(.*?)<\/span>/',$grab,$release);
    preg_match('/<span data-spec="body-hl">(.*?)<\/span>/',$grab,$body);
    preg_match('/<span data-spec="os-hl">(.*?)<\/span>/',$grab,$os);
    preg_match('/<span data-spec="storage-hl">(.*?)<\/span>/',$grab,$storage);
    preg_match('/<span data-spec="displaysize-hl">(.*?)<\/span>/',$grab,$displaysize);
    preg_match('/<div data-spec="displayres-hl">(.*?)<\/div>/',$grab,$displayres);
    preg_match('/<span data-spec="camerapixels-hl">(\d+)<\/span><span>(.*?)<\/span>/',$grab,$camerapixels);
    preg_match('/<div data-spec="videopixels-hl">(.*?)<\/div>/',$grab,$videopixels);
    preg_match('/<span data-spec="ramsize-hl">(.*?)<\/span><span>(.*?)<\/span>/',$grab,$ramsize);
    preg_match('/<img alt="(.*?)MORE PICTURES" src=(.*?)>/',$grab,$picture);
    preg_match('/<span data-spec="batsize-hl">(\d+)<\/span><span>(.*?)<\/span>/',$grab,$batsize);
    preg_match('/<div data-spec="battype-hl">(.*?)<\/div>/',$grab,$battype);
    preg_match('/<p data-spec="comment">(.*?)<\/p>/',$grab,$comment);

    $tabel = explode('<table cellspacing="0">',$grab);

    $pecahTabel = array();
    for($i=1;$i<=13;$i++){
        $data = explode('</table>',$tabel[$i]);
        $pecahTabel[] = $data[0];
    }
    
    $atur = array();
    foreach($pecahTabel as $key => $value){
        preg_match_all('/<td class="ttl">(.*?)<\/td>/',$value,$ttl);
        preg_match_all('/<td class="nfo"(.*?)>(.*?)<\/td>/',$value,$nfo);
        
        $ttlnfo = array();
        foreach($ttl[1] as $kunci => $value){
            $ttlnfo[] = mb_convert_encoding(strip_tags($ttl[1][$kunci]).' : '.strip_tags($nfo[2][$kunci]), 'UTF-8', 'UTF-8');
        }

        $atur[] = $ttlnfo;
    }

    if(empty($comment[1])){
        $comment[1] = '';
    }

    $result = array(
        'title' => $title[1],
        'description' => $description[1],
        'release' => $release[1],
        'body' => $body[1],
        'os' => $os[1],
        'storage' => $storage[1],
        'displaysize' => $displaysize[1],
        'displayres' => $displayres[1],
        'camerapixels' => $camerapixels[1].' '.$camerapixels[2],
        'videopixels' => $videopixels[1],
        'ramsize' => $ramsize[1].' '.$ramsize[2],
        'picture' => $picture[2],
        'batsize' => $batsize[1].' '.$batsize[2],
        'battype' => $battype[1],
        'comment' => $comment[1],
        'table' => $atur,
    );
    return json_encode($result,JSON_PRETTY_PRINT);
}
?>
