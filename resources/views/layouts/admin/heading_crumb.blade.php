<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ $page_header or ''}}
        <small>{{ $sub_header or ''}}</small>
    </h1>
    <ol class="breadcrumb">
        <?php
        //print_r($this->breadcrumb);
        if (!empty($this->breadcrumb))
            foreach ($this->breadcrumb as $key => $crumb) {
                ?>
                <li class="<?php if(!isset($crumb['link'])) echo 'active'; ?>">
                    <?php if(isset($crumb['link'])){?>
                    <a href="<?php echo (isset($crumb['link'])) ? ADMIN_HTTP_PATH . $crumb['link'] : "#"; ?>"><?php echo ($crumb['content']); ?></a>
                    <?php 
                    }else{
                        echo ($crumb['content']); 
                    }?>
                </li>
                <?php
            }
        ?>
    </ol>
</section>
