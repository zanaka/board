<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

// 掲示板全体画面
$app->get('/board', function (Request $request, Response $response) {
    return $this->renderer->render($response, 'board.phtml');
});

//掲示板(上)　内容入力フォーム
$app->post('/board', function (Request $request, Response $response) {
    $subject = $request->getParsedBodyParam('subject');
    $subject = $request->getParsedBodyParam('subject');
    // ここに保存の処理を書く
    $sql1 = 'INSERT INTO message (body) values (:subject)';
    $sql2 = 'INSERT INTO message (user_name) values (:subject)';
    $stmt = $this->db->prepare($sql);
    $result = $stmt->execute(['subject' => $subject]);
    if (!$result) {
        throw new \Exception('could not save the ticket');
    }

    // 保存が正常にできたら一覧ページへリダイレクトする
    return $response->withRedirect("/board");
});





$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
