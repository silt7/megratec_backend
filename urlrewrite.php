<?php
$arUrlRewrite=array (
  1 => 
  array (
    'CONDITION' => '#^/e-store/books/reviews/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/e-store/books/reviews/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/forum/posts/(.*)#',
    'RULE' => 'post=$1',
    'ID' => '',
    'PATH' => '/forum/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/forum/(.*)/(.*)#',
    'RULE' => 'section=$1&topic=$2',
    'ID' => '',
    'PATH' => '/forum/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/forum/(.*)#',
    'RULE' => 'section=$1',
    'ID' => '',
    'PATH' => '/forum/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
