<table class="webdiskRecentList tableList">
	<tbody>
		{foreach from=$databaseItems item=item}
			{assign var=itemID value=$item.itemID}
			<tr class="container-{cycle values='1,2'}">
				<td class="columnIcon">
					<img src="{icon}{if $item.icon}{$item.icon}{else}databaseCategoryM.png{/if}{/icon}" alt="" style="height: 24px; width:24px;" />
				</td>
				
				<td style="width: 25%">
					<div class="webdiskCategoryLink">
						<p><a href="index.php?page=Database&c={$item.categoryID}">{$item.cName}</a></p>
					</div>
				</td>
				
				<td class="columnIcon">
					<img src="{icon}databaseFileArchiveL.png{/icon}" alt="" style="height: 24px; width:24px;" />
				</td>
				
				<td style="width: 50%">
					<div id="webdiskLink{$item.itemID}">
						<p><a href="index.php?page=DatabaseItem&id={$item.itemID}">{$item.name}</a></p>
						<p class="smallFont light">{$item.description|truncate:70:"..."}</p>
					</div>
				</td>
				
				<td class="columnTime" style="width: 25%">
					<div class="webdiskTime">
						<p>
							{lang}wbb.board.threads.postBy{/lang}
							{if $item.author}
								<a href="index.php?page=User&amp;userID={$item.author}{@SID_ARG_2ND}">{$item.authorName}</a>
							{else}
								<i>{$item.authorName}</i>
							{/if}
						</p>
						<p class="smallFont light">
							({@$item.createTime|shorttime})
						</p>
					</div>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>