<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

$arParams['COUNT_IN_LINE'] = (isset($arParams['COUNT_IN_LINE']) ? intval($arParams['COUNT_IN_LINE']) : 3);
$arParams['COUNT_IN_LINE'] = (($arParams['COUNT_IN_LINE'] > 1 && $arParams['COUNT_IN_LINE'] < 6) ? $arParams['COUNT_IN_LINE'] : 3);
?>
<?if($arResult['ITEMS']):?>
	<div class="item-views partners list list-type-block within">
		<?// top pagination?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<div class="pagination_nav">
				<?=$arResult["NAV_STRING"]?>
			</div>
		<?endif;?>
		<div class="items">
			<?foreach($arResult['ITEMS'] as $i => $arItem):?>
				<?
				// edit/add/delete buttons for edit mode
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				// use detail link?
				$bDetailLink = ($arParams['SHOW_DETAIL_LINK'] != 'N' ? true : false);
				// show preview picture?
				$bImage = strlen($arItem['FIELDS']['PREVIEW_PICTURE']['SRC']);
				$imageSrc = ($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['SRC'] : false);
				$imageDetailSrc = ($bImage ? $arItem['FIELDS']['DETAIL_PICTURE']['SRC'] : false);
				?>

				<div class="item border shadow <?=(isset($arParams['IMG_PADDING']) && $arParams['IMG_PADDING'] == 'Y' ? 'padding-img' : '');?> <?=($bImage ? '' : ' wti')?> clearfix" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
					<div class="wrap">
						<?if($bImage):?>
							<div class="image <?=(isset($arParams['IMG_PADDING']) && $arParams['IMG_PADDING'] == 'Y' ? 'padding' : '');?>">
								<?if($bDetailLink):?>
									<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
								<?endif;?>
									<img src="<?=$imageSrc?>" alt="<?=($bImage ? $arItem['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" class="img-responsive" />
								<?if($bDetailLink):?>
									</a>
								<?endif;?>
							</div>
						<?endif;?>
						<div class="body-info">
							<?// element name?>
							<?if(strlen($arItem['FIELDS']['NAME'])):?>
								<?$bHasSocProps = (isset($arItem['SOCIAL_PROPS']) && $arItem['SOCIAL_PROPS']);?>
								<div class="title-wrapper <?=($bHasSocProps ? 'bottom-props' : '');?>">
									<div class="title">
										<?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="dark-color"><?endif;?>
											<?=$arItem['NAME']?>
										<?if($bDetailLink):?></a><?endif;?>
									</div>
									<?if($bHasSocProps):?>
										<!-- noindex -->
											<?foreach($arItem['SOCIAL_PROPS'] as $arProp):?>
												<a href="<?=$arProp['VALUE'];?>" target="_blank" rel="nofollow" class="value <?=strtolower($arProp['CODE']);?>"><?=$arProp['VALUE'];?></a>
											<?endforeach;?>
										<!-- /noindex -->
									<?endif;?>
								</div>
							<?endif;?>

							<?// element post?>
							<?if(strlen($arItem['DISPLAY_PROPERTIES']['POST']['VALUE'])):?>
								<div class="post"><?=$arItem['DISPLAY_PROPERTIES']['POST']['VALUE']?></div>
								<?unset($arItem['DISPLAY_PROPERTIES']['POST']);?>
							<?endif;?>

							<?// element preview text?>
							<?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
								<div class="previewtext">
									<?if($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
										<p><?=$arItem['FIELDS']['PREVIEW_TEXT']?></p>
									<?else:?>
										<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
									<?endif;?>
								</div>
							<?endif;?>

							<?// element display properties?>
							<?if($arItem['DISPLAY_PROPERTIES']):?>
								<div class="properties">
									<?foreach($arItem['DISPLAY_PROPERTIES'] as $PCODE => $arProperty):?>
										<?if($arProperty['DISPLAY_VALUE']):?>
											<?if(in_array($PCODE, array('PERIOD', 'TITLE_BUTTON', 'LINK_BUTTON'))) continue;?>
											<div class="property <?=strtolower($PCODE);?>">
												<div class="title-prop font_upper"><?=$arProperty['NAME']?></div>
												<div class="value font_sm">
													<?if(is_array($arProperty['DISPLAY_VALUE'])):?>
														<?$val = implode('&nbsp;/&nbsp;', $arProperty['DISPLAY_VALUE']);?>
													<?else:?>
														<?$val = $arProperty['DISPLAY_VALUE'];?>
													<?endif;?>
													<?if($PCODE == 'SITE'):?>
														<!--noindex-->
														<a href="<?=(strpos($arProperty['VALUE'], 'http') === false ? 'http://' : '').$arProperty['VALUE'];?>" rel="nofollow" target="_blank">
															<?=strpos($arProperty['VALUE'], '?') === false ? $arProperty['VALUE'] : explode('?', $arProperty['VALUE'])[0]?>
														</a>
														<!--/noindex-->
													<?elseif($PCODE == 'EMAIL'):?>
														<a href="mailto:<?=$val?>"><?=$val?></a>
													<?else:?>
														<?=$val?>
													<?endif;?>
												</div>
											</div>
										<?endif;?>
									<?endforeach;?>
								</div>
							<?endif;?>
						</div>
						<?if($bDetailLink):?>
							<a class="arrow_link" href="<?=$arItem['DETAIL_PAGE_URL'];?>"></a>
						<?endif;?>
					</div>
				</div>
			<?endforeach;?>
		</div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<div class="pagination_nav">
				<?=$arResult["NAV_STRING"]?>
			</div>
		<?endif;?>
	</div>
<?endif;?>