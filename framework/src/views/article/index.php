<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: #333; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 10px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        .article { margin-bottom: 40px; }
        .article-meta { color: #777; font-size: 0.9em; margin-bottom: 20px; }
        .article-content { line-height: 1.6; }
        .comments-section { margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
        .comment { margin-bottom: 20px; padding: 15px; background-color: #f9f9f9; border-radius: 5px; }
        .comment-meta { font-size: 0.8em; color: #777; margin-bottom: 5px; }
        .comment-text { line-height: 1.5; }
        .comment-replies { margin-left: 30px; margin-top: 15px; }
        .back-link { margin-top: 20px; display: block; }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <a href="<?= BASE_URL ?>/">Главная</a>
            <a href="<?= BASE_URL ?>/home/about">О блоге</a>
            <a href="<?= BASE_URL ?>/article/list">Список статей</a>
        </nav>
        
        <article class="article">
            <h1><?= $article['title'] ?></h1>
            <div class="article-meta">
                Опубликовано: <?= date('d.m.Y H:i', strtotime($article['created_at'])) ?>
            </div>
            <div class="article-content">
                <p><?= $article['description'] ?></p>
                <div><?= nl2br($article['text']) ?></div>
            </div>
        </article>
        
        <div class="comments-section">
            <h2>Комментарии (<?= count($comments) ?>)</h2>
            
            <?php
            // Функция для рендеринга вложенных комментариев
            function renderReplies($replies) {
                foreach ($replies as $reply): ?>
                    <div class="comment">
                        <div class="comment-meta">
                            Автор: <?= $reply['author_id'] ?> | <?= date('d.m.Y H:i', strtotime($reply['created_at'])) ?>
                        </div>
                        <div class="comment-text">
                            <?= nl2br($reply['text']) ?>
                        </div>
                        
                        <?php if (!empty($reply['replies'])): ?>
                            <div class="comment-replies">
                                <?php renderReplies($reply['replies']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
            }
            ?>
            
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="comment-meta">
                            Автор: <?= $comment['author_id'] ?> | <?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?>
                        </div>
                        <div class="comment-text">
                            <?= nl2br($comment['text']) ?>
                        </div>
                        
                        <?php if (!empty($comment['replies'])): ?>
                            <div class="comment-replies">
                                <?php renderReplies($comment['replies']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Нет комментариев.</p>
            <?php endif; ?>
        </div>
        
        <a href="<?= BASE_URL ?>/article/list" class="back-link">&laquo; Вернуться к списку статей</a>
    </div>
</body>
</html> 