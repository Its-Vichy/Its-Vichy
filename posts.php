<?php

// Load Composer's autoload
require_once __DIR__ . '/vendor/autoload.php';

// Load the RSS feed
$feed = Feed::loadRss('https://tech.osteel.me/feeds/rss.xml')->toArray();

// Generate the list of blog posts
$posts = '';
foreach (array_slice($feed['item'], 0, 5) as $post) {
    $date   = date('d/m/Y', strtotime($post['pubDate']));
    $posts .= sprintf("\n* **[%s]** [%s](%s \"%s\")", $date, $post['title'], $post['link'], $post['title']);
}

// Generate the new content
$content = preg_replace(
    '#<!-- posts -->.*<!-- /posts -->#s',
    sprintf('<!-- posts -->%s<!-- /posts -->', $posts),
    file_get_contents('README.md')
);

// Overwrite the file
file_put_contents('README.md', $content);
