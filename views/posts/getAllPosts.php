<?php
use app\models\Posts;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;

$this->title = 'Все публикации';
?>



<?php if (!empty($models)):?>
    <?php echo "Статьи по вашему запросу:";?>
    <?php foreach ($models as $model):?>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="wp-block property list">
                        <div class="wp-block-body">

                            <?php if ($model->image):?>
                            <div class="wp-block-img">
                                    <?php echo '<img src="web/uploads/'.$model->image.'" alt="" width="300" height="200">' ?>
                            </div>
                            <?php endif;?>

                            <div class="wp-block-content">
                                <small>
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>Опубликовано: <?php echo getPostDate($model-> date_of_creation)?></small>
                                <h4 class="content-title"><?php echo getPostLink($model->title, $model->id); ?></h4>
                                <p class="description"><?php echo getPostPreview($model->content,$model->id) ?> </p>
                                <span class="pull-left">
                      <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                    </span>
                                <span class="pull-right">
                      <span class="capacity">
                        <i class="fa fa-user"></i> <?php echo $model->users->username ?>
                      </span>
                    </span>
                            </div>
                        </div>
                        <div class="wp-block-footer">
                            <ul class="aux-info">
                                <li><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <?php echo "Глазик: " . $model->view_count ?> </li>
                                <li><span class=" glyphicon glyphicon-comment" aria-hidden="true"></span> 5</li>
                                <li><span class="glyphicon glyphicon-star" aria-hidden="true"></span> 2</li>
                                <li><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> +5 <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></li>
                                <li><span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Теги: <?php echo getPreviewTags($model) ?> </li>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    <?php endforeach;?>
    <?php displayPagination($pages);?>

<?php else:?>
    <?php echo "Ни одной статьи не найдено по данному запросу";?>
<?php endif;?>



<?php
/**
* Return post content in specific format
* @return string post content
*/
function getPostPreview($content, $post_id): string
{
    if (strlen($content) >= 500){
        $preview = formedPostPreview($content, $post_id);
    }else{
        $preview = $content;
    }
    return  $preview ;
}
/**
 * Return short post preview
 * @return string short post preview
 */
function formedPostPreview($content, $post_id): string
{
    $preview = substr($content, 0,500);
    return $preview . "...".getPostLink("читать далее", $post_id);
}

/**
 * Return post date in specific format
 * @return string date of creation post
 */
function getPostDate($date_of_creation): string
{
    //format mysql datetime "Y-m-d H:i:s"
    $datetime = explode(" ", $date_of_creation);
    $date =  $datetime[0];
    $time = new DateTime($datetime[1]);

    if ($date == date("Y-m-d") ){
        return "Сегодня в ". $time->format('H:i');
    }else{
        return $date;
    }
}

/**
 * Return HTML link on concrete post
 * @return string link on post
 */
function getPostLink($text, $post_id): string
{
    $action = 'posts/get-post';
    return Html::a($text, [$action, 'post_id' => $post_id], ['class' => 'profile-link']);
}


/**
 * Return short version of tags in string format
 * @return string of tags
 */
function getPreviewTags($model):string
{
    define('PREVIEW_TAGS_COUNT', 3);
    $tagString = "";
    $preview_counter = 0;

    if(count($model->tags) > 0){

        foreach ($model->tags as $tag){
            if ($preview_counter == 0){
                $tagString .= convertTagToLink($tag->tag_name);
            }else{
                $tagString .= ", ". convertTagToLink($tag->tag_name);
            }
            $preview_counter++;

            if ($preview_counter > PREVIEW_TAGS_COUNT){
                $count_of_others = count($model->tags) - PREVIEW_TAGS_COUNT;
                $tagString .= " + еще ".  $count_of_others ;
                break;
            }
        }

    }else {
        $tagString = "теги отсутствуют" . "</br>";
    }

    return $tagString;
}

//todo в разработке
function convertTagToLink($tag){
    $action = 'posts/get-post';
    $post_id = 26;
    return Html::a($tag, [$action, 'post_id' => $post_id], ['class' => 'profile-link']);
}

/**
 * Display pagination
 */
function displayPagination($pages)
{
     echo LinkPager::widget([
        'pagination' => $pages,
    ]);
}
?>

