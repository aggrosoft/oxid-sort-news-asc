<?php

namespace Aggrosoft\SortNewsAsc\Application\Model;

class NewsList extends NewsList_parent
{
    public function loadNews($iFrom = 0, $iLimit = 10)
    {
        if ($iLimit) {
            $this->setSqlLimit($iFrom, $iLimit);
        }

        $sNewsViewName = getViewName('oxnews');
        $oBaseObject = $this->getBaseObject();
        $sSelectFields = $oBaseObject->getSelectFields();
        $params = [];

        if ($oUser = $this->getUser()) {
            // performance - only join if user is logged in
            $sSelect = "select $sSelectFields from $sNewsViewName ";
            $sSelect .= "left join oxobject2group on oxobject2group.oxobjectid=$sNewsViewName.oxid where ";
            $sSelect .= "oxobject2group.oxgroupsid in ( select oxgroupsid from oxobject2group where oxobjectid = :oxobjectid ) or ";
            $sSelect .= "( oxobject2group.oxgroupsid is null ) ";

            $params[':oxobjectid'] = $oUser->getId();
        } else {
            $sSelect = "select $sSelectFields, oxobject2group.oxgroupsid from $sNewsViewName ";
            $sSelect .= "left join oxobject2group on oxobject2group.oxobjectid=$sNewsViewName.oxid where oxobject2group.oxgroupsid is null ";
        }

        $sSelect .= " and " . $oBaseObject->getSqlActiveSnippet();
        $sSelect .= " and $sNewsViewName.oxshortdesc <> '' ";
        $sSelect .= " group by $sNewsViewName.oxid order by $sNewsViewName.oxdate asc ";

        $this->selectString($sSelect, $params);
    }
}