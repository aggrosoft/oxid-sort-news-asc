<?php

$sMetadataVersion = '2.0';

$aModule = array(
    'id'           => 'agsortnewsasc',
    'title'        => 'Sort News Articles Ascending',
    'description'  => 'Sorts news articles in ascending order.',
    'thumbnail'    => '',
    'version'      => '1.0.0',
    'author'       => 'Aggrosoft GmbH',
    'extend'      => array(
        \OxidEsales\Eshop\Application\Model\NewsList::class => Aggrosoft\SortNewsAsc\Application\Model\NewsList::class
    ),
);
