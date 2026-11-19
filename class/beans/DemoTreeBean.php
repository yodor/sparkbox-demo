<?php
include_once("beans/NestedSetBean.php");

/**
 * The tree of the tree view page (a nested set) - its sample nodes are added on the first visit of the page
 */
class DemoTreeBean extends NestedSetBean
{
    protected string $createString = "CREATE TABLE `demo_tree` (
 `nodeID` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `node_name` varchar(64) NOT NULL,
 `parentID` int(11) unsigned NOT NULL DEFAULT 0,
 `lft` int(11) unsigned NOT NULL,
 `rgt` int(11) unsigned NOT NULL,
 PRIMARY KEY (`nodeID`),
 KEY `lft` (`lft`),
 KEY `rgt` (`rgt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    public function __construct()
    {
        parent::__construct("demo_tree");
    }

    /**
     * The sample nodes when the tree is empty: two levels of the parts of a computer
     * @return void
     * @throws Exception
     */
    public function seed() : void
    {
        $count = $this->query($this->key());
        $count->stmt->limit(1);
        $count->exec();
        $empty = is_null($count->next());
        $count->free();
        if (!$empty) return;

        $tree = array(
            "Computer" => array("Processor" => array("Cores", "Cache"), "Memory" => array("RAM", "ROM"), "Storage" => array("SSD", "HDD")),
            "Network" => array("Wired" => array("Ethernet"), "Wireless" => array("Wi-Fi", "Bluetooth")),
        );
        foreach ($tree as $name => $children) {
            $id = $this->insert(array("node_name" => $name, "parentID" => 0));
            foreach ($children as $childName => $leaves) {
                $childID = $this->insert(array("node_name" => $childName, "parentID" => $id));
                foreach ($leaves as $leaf) {
                    $this->insert(array("node_name" => $leaf, "parentID" => $childID));
                }
            }
        }
    }
}
