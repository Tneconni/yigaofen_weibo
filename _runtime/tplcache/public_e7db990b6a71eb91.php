<?php if (!defined('THINK_PATH')) exit();?><?php $cancomment = intval(CheckPermission('core_normal','feed_comment'));
$canfeedshare = CheckPermission('core_normal','feed_share'); ?>
<?php foreach($data as $vl){ ?>
	<?php $cancomment_old = empty($vl['feed_info']['app_row_id'])  ? 0 : 1; ?>
	<div class="feed_lists clearfix">
	<dl class="feed_list"  id ='feed_top_<?php echo ($vl['feed_info']['feed_id']); ?>' model-node='feed_list'>
        <dt class="face"> <a href="<?php echo ($vl['feed_info']['user_info']['space_url']); ?>"><img src="<?php echo ($vl['feed_info']['user_info']['avatar_small']); ?>"  event-node="face_card" uid='<?php echo ($vl['feed_info']['user_info']['uid']); ?>'></a></dt>
			<dd class="content"> 
				  <span style="border: 1px solid #D30E00; border-radius: 2px 2px 2px 2px;color: #D30E00;display: inline-block;font-size: 12px;height: 16px;line-height: 16px;margin-right: 3px;overflow: hidden; padding: 0 2px; text-align: center;vertical-align: text-bottom;" class="right">置顶微博</span>
				 <span event-node="show_admin" event-args="feed_id=<?php echo ($vl['feed_info']['feed_id']); ?>&uid=<?php echo ($vl['feed_info']['user_info']['uid']); ?>&feed_del=<?php echo CheckPermission('core_admin','feed_del');?>&channel_recommend=<?php echo CheckPermission('channel_admin','channel_recommend');?>" href="javascript:;" class="right f12 f9 hover" style="display:none;cursor:pointer;margin-right:10px;">管理</span>
				 <span class="right f12 f9 hover" style="margin-right:10px;">
				 <a href="javascript:void(0)" onclick="close_feed_top(<?php echo ($vl['feed_info']['feed_id']); ?>)"><p title="关闭">X</p></a>
				 </span>
				 <?php if($vl['feed_info']['is_del']==0){ ?>
				 <p class="hd">
				  <?php echo getUserSpace($vl["feed_info"]["uid"],'','','{uname}') ?>
				  <?php if(in_array($vl['feed_info']['user_info']['uid'],$followUids)){ ?>
				  <?php echo W('Remark',array('uid'=>$vl['feed_info']['user_info']['uid'],'remark'=>$remarkHash[$vl['feed_info']['user_info']['uid']],'showonly'=>1));?>
				  <?php } ?>
				  <?php if(!empty($vl['feed_info']['body'])){ ?>
				  <?php } ?>
				</p>
				
				<span class="contents">
							
				<?php echo (format($vl['feed_info']['body'],true)); ?></span>
				 <p class="info"> 
					  <span class="right">
					  	<?php echo W('Digg', array('feed_id'=>$vl['feed_info']['feed_id'], 'digg_count'=>$vl['feed_info']['digg_count'], 'diggArr'=>$diggArr));?>
					    <i class="vline">|</i>
						  <?php if($vl['feed_info']['actions']['repost']=='true' && $canfeedshare){ ?>
						  <?php $sid = !empty($vl['feed_info']['app_row_id'])? $vl['feed_info']['app_row_id'] : $vl['feed_info']['feed_id'];
							$cancomment_old = in_array($vl['feed_info']['type'],$cancomment_old_type) ? 1 : 0; ?>
						  <?php echo W('Share',array('sid'=>$sid,'stable'=>$vl['feed_info']['app_row_table'],'initHTML'=>'','current_table'=>'feed','current_id'=>$vl['feed_info']['feed_id'],'nums'=>$vl['feed_info']['repost_count'],'appname'=>$vl['feed_info']['app'],'cancomment'=>$cancomment_old,'feed_type'=>$vl['feed_info']['type'],'is_repost'=>$vl['feed_info']['is_repost']));?> <i class="vline">|</i>
						  <?php } ?>

						  <?php if($vl['feed_info']['actions']['favor']== 'true'){ ?>
						  <?php echo W('Collection',array('type'=>$type,'sid'=>$vl['feed_info']['feed_id'],'stable'=>'feed','sapp'=>$vl['feed_info']['app']));?>
						  <?php } ?>
					
						  <?php if($vl['feed_info']['actions']['comment']== 'true'){ ?>
						  <i class="vline">|</i> <a event-node="comment" href="javascript:void(0)" event-args='row_id=<?php echo ($vl['feed_info']['feed_id']); ?>&app_uid=<?php echo ($vl['feed_info']['uid']); ?>&app_row_id=<?php echo ($vl['feed_info']['app_row_id']); ?>&to_comment_id=0&to_uid=0&app_name=<?php echo ($vl['feed_info']['app']); ?>&table=feed&cancomment=<?php echo ($cancomment); ?>&cancomment_old=<?php echo ($cancomment_old); ?>'><?php echo L('PUBLIC_STREAM_COMMENT');?>
						  <?php if($vl['feed_info']['comment_count']!=0){ ?>
						  (<?php echo ($vl['feed_info']['comment_count']); ?>)
						  <?php } ?>
						  </a>
						  <?php } ?>
						  </span>
						   <span> <a class="date" date="<?php echo ($vl['feed_info']['publish_time']); ?>" href="<?php echo U('public/Profile/feed',array('feed_id'=>$vl['feed_info']['feed_id'],'uid'=>$vl['feed_info']['uid']));?>"><?php echo (friendlydate($vl["feed_info"]["publish_time"])); ?></a> 
						   <span><?php echo ($vl['feed_info']['from']); ?></span>
						  <em class="hover">
						  <?php if($vl['feed_info']['actions']['delete']== 'true'){ ?>
						  <!-- 做普通删除权限 和 管理删除权限 判断 & 只有微博可以被删除  -->
						  <?php if(($vl['feed_info']['user_info']['uid'] == $GLOBALS['ts']['mid'] && CheckPermission('core_normal','feed_del')) || CheckPermission('core_admin','feed_del')){ ?>
						  <a href="javascript:void(0)" event-node ='delFeed' event-args='feed_id=<?php echo ($vl['feed_info']['feed_id']); ?>&uid=<?php echo ($vl['feed_info']['user_info']['uid']); ?>'><?php echo L('PUBLIC_STREAM_DELETE');?></a>
						  <?php } ?>
						  <?php } ?>
						  <?php if($vl['feed_info']['user_info']['uid'] != $GLOBALS['ts']['mid']){ ?>
						  <?php if(CheckPermission('core_normal','feed_report')){ ?>
						  <a href="javascript:void(0)" event-node='denounce' event-args='aid=<?php echo ($vl['feed_info']['feed_id']); ?>&type=feed&uid=<?php echo ($vl['feed_info']['user_info']['uid']); ?>'><?php echo L('PUBLIC_STREAM_REPORT');?></a>
						  <?php } ?>
						  <?php } ?>
						  </em> 
					  </span>
				</p>
				<div model-node="comment_detail" class="repeat clearfix" style="display:none;"></div>
				<?php }else{ ?>
				<p><?php echo L('PUBLIC_INFO_ALREADY_DELETE_TIPS');?></p>
				<p class="info">
				  <?php if($vl['feed_info']['actions']['favor']== 'true'){ ?>
				  <?php echo W('Collection',array('type'=>$type,'sid'=>$vl['feed_info']['feed_id'],'stable'=>'feed','sapp'=>$vl['feed_info']['app']));?>
				  <?php } ?>
				</p>
			    <?php } ?>
       </dd>
   </dl>
</div>	
<?php } ?>
<script type="text/javascript">
function close_feed_top(feed_id){
	$.post("<?php echo Addons::createAddonUrl('FeedTop', 'close_feed_top');?>",{feed_id:feed_id},function(txt){
		if(txt==1){
		    $("#feed_top_"+feed_id).fadeOut(1000);
		}else{
			alert('我感冒了，不灵了，请帮我联系管理员吧！');
		}
	});
}
</script>