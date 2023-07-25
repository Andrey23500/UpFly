<?php

// Функция для получения информации о разделе и его дочерних элементах
function getSectionAndChildrenInfo($sectionId, $arInfo = array())
{
   // Получаем информацию о разделе
   $arSectionInfo = CIBlockSection::GetByID($sectionId)->Fetch();
   if ($arSectionInfo) {
      // Получаем информацию о картинке, описании и дате создания раздела
      $sectionInfo = array(
         'ID' => $arSectionInfo['ID'],
         'NAME' => $arSectionInfo['NAME'],
         'PICTURE' => $arSectionInfo['PICTURE'],
         'DESCRIPTION' => $arSectionInfo['DESCRIPTION'],
         'DATE_CREATE' => $arSectionInfo['DATE_CREATE'],
      );
      $arInfo[] = $sectionInfo;

      // Получаем дочерние разделы
      $arFilter = array('IBLOCK_ID' => $arSectionInfo['IBLOCK_ID'], 'SECTION_ID' => $arSectionInfo['ID']);
      $rsChildSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter, false, array('ID', 'NAME', 'DESCRIPTION'));
      while ($arChildSection = $rsChildSections->Fetch()) {
         // Получаем информацию о дочерних разделах рекурсивно
         $arInfo = getSectionAndChildrenInfo($arChildSection['ID'], $arInfo);
      }

      // Получаем дочерние элементы
      $arFilter = array('IBLOCK_ID' => $arSectionInfo['IBLOCK_ID'], 'SECTION_ID' => $arSectionInfo['ID']);
      $rsElements = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilter, false, false, array('ID', 'NAME', 'DETAIL_TEXT'));
      while ($arElement = $rsElements->Fetch()) {
         // Получаем информацию о дочерних элементах и добавляем ее в массив
         $elementInfo = array(
            'ID' => $arElement['ID'],
            'NAME' => $arElement['NAME'],
            'DESCRIPTION' => $arElement['DETAIL_TEXT'],
         );
         $arInfo[] = $elementInfo;
      }
   }

   return $arInfo;
}

$sectionId = 1;
$result = getSectionAndChildrenInfo($sectionId);

print_r($result);
