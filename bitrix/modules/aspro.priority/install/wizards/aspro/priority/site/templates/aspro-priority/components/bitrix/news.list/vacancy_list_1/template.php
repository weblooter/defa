<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?if($arResult['SECTIONS']):?>
	<div class="item-views vacancy_list">
		<?// top pagination?>
		<?if($arParams['DISPLAY_TOP_PAGER']):?>
			<?=$arResult['NAV_STRING']?>
		<?endif;?>
		<div class="group-content">
			<?// group elements by sections?>
			<?foreach($arResult['SECTIONS'] as $SID => $arSection):?>
				<?
				// edit/add/delete buttons for edit mode
				$arSectionButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], array('SESSID' => false, 'CATALOG' => true));
				$this->AddEditAction($arSection['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
				$this->AddDeleteAction($arSection['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div id="<?=$this->GetEditAreaId($arSection['ID'])?>" class="tab-pane <?=(!$si++ || !$arSection['ID'] ? 'active' : '')?>">
					<?if($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y'):?>
						<?if($arParams['SHOW_SECTION_NAME'] != 'N'):?>
							<?// section name?>
							<?if(strlen($arSection['NAME'])):?>
								<h3><?=$arSection['NAME']?></h3>
							<?endif;?>
						<?endif;?>

						<?// section description text/html?>
						<?if(strlen($arSection['DESCRIPTION']) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
							<div class="text_before_items">
								<?=$arSection['DESCRIPTION']?>
							</div>
						<?endif;?>
					<?endif;?>

					<div class="items accordion-type-1">
						<?foreach($arSection['ITEMS'] as $key => $arItem):?>
							<?
							// edit/add/delete buttons for edit mode
							$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
							$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
							// use detail link?
							$bDetailLink = ($arParams['SHOW_DETAIL_LINK'] != 'N' || ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1 && !strlen($arItem['DETAIL_TEXT'])) ? true : false);
							// preview picture
							$bImage = strlen($arItem['FIELDS']['PREVIEW_PICTURE']['SRC']);
							$imageSrc = ($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['SRC'] : SITE_TEMPLATE_PATH.'/images/noimage.png');
							$imageDetailSrc = ($bImage ? $arItem['FIELDS']['DETAIL_PICTURE']['SRC'] : false);
							// show active date period
							$bActiveDate = strlen($arItem['DISPLAY_PROPERTIES']['PERIOD']['VALUE']) || ($arItem['DISPLAY_ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', $arParams['FIELD_CODE']));
							?>							
							<?if(isset($arItem['FIELDS']['NAME']) && strlen($arItem['FIELDS']['NAME'])):?>
								<?
								$bDetailText = (isset($arItem['FIELDS']['DETAIL_TEXT']) && strlen($arItem['FIELDS']['DETAIL_TEXT']) ? true : false);
								?>
								<div class="item border shadow<?=(!$arItem["DISPLAY_PROPERTIES"] ? ' wtprops' : '')?><?=($bImage ? '' : ' wti')?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
									<div class="accordion-head accordion-close" data-toggle="collapse" data-parent="#accordion<?=$key;?>" href="<?=($bDetailText ? '#accordion'.$key : '');?>">
										<?if($bDetailText):?>
											<span class="arrow_open pull-right"></span>
										<?endif;?>
										<div class="title"><?=$arItem['NAME']?></div>
										<?if($arItem["DISPLAY_PROPERTIES"]):?>
											<div class="properties">
												<?$i = 0;?>
												<?foreach($arItem["DISPLAY_PROPERTIES"] as $PCODE => $arProperty):?>
													<?
													if($arProperty['PROPERTY_TYPE'] == 'E' || $arProperty['PROPERTY_TYPE'] == 'G')
														continue;
													?>
													<span class="property <?=strtolower($PCODE);?>">
														<span class="value font_upper">
															<?=($PCODE == 'QUALITY' ? $arProperty['NAME'].':&nbsp;' : '');?>
															<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
																<?$val = implode(",  ", $arProperty["DISPLAY_VALUE"]);?>
															<?else:?>
																<?$val = $arProperty["DISPLAY_VALUE"];?>
															<?endif;?>
															<?if($PCODE == "SITE"):?>
																<!--noindex-->
																<a href="<?=(strpos($arProperty['VALUE'], 'http') === false ? 'http://' : '').$arProperty['VALUE'];?>" rel="nofollow" target="_blank">
																	<?=$arProperty['VALUE'];?>
																</a>
																<!--/noindex-->
															<?elseif($PCODE == "EMAIL"):?>
																<a href="mailto:<?=$val?>"><?=$val?></a>
															<?else:?>
																<?=$val?>
															<?endif;?>
														</span>
														<?if($i != count($arItem["DISPLAY_PROPERTIES"]) - 1):?>
															<span class="separator font_upper">&mdash;</span>
														<?endif;?>
													</span>
													<?++$i;?>
												<?endforeach;?>
											</div>
										<?endif;?>	
										<?if(isset($arItem['PAY'])):?>
											<div class="pay"><?=$arItem['PAY'];?></div>
										<?endif;?>
									</div>
									<?if($bDetailText):?>
										<div id="accordion<?=$key;?>" class="panel-collapse collapse">
											<div class="accordion-body">
												<div class="row">
													<div class="col-md-12">
														<div class="text"><?=$arItem['DETAIL_TEXT'];?></div>
														<?if($arParams['FORM'] == 'Y'):?>
															<div class="button"><span class="btn btn-default animate-load" data-event="jqm" data-name="resume" data-param-id="<?=CPriority::getFormID('aspro_priority_resume');?>" data-autoload-POST="<?=CPriority::formatJsName($arItem['NAME'])?>"><?=$arParams["FORM_BUTTON_TITLE"];?></span></div>
														<?endif;?>
													</div>
												</div>
											</div>
										</div>
									<?endif;?>
								</div>
							<?endif;?>
						<?endforeach;?>
					</div>
				</div>
			<?endforeach;?>
		</div>

		<?// bottom pagination?>
		<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
			<?=$arResult['NAV_STRING']?>
		<?endif;?>
	</div>
<?endif;?>