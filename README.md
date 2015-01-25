<div class="row row-pic">
[loop]
<div class="col-xs-6 col-sm-3 item">
<a href="{url}"{target} class="piclink"><img src="{pic}" class="img-responsive" alt="{title}" /></a>                     
</div>
[/loop]
</div>


	ALTER TABLE `pre_home_album` ADD `picid` INT NOT NULL DEFAULT '0' AFTER `pic`;