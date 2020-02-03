<?php
class Page{
    var $pagesize;//一页的行数
    var $numrows;//总记录条数
    var $pages;//总页数
    var $page;//当前页数
    var $offset;
    var $url;
    function pagedate($str1,$str2,$str3){
        $this->pagesize=$str1;
        $this->numrows=$str2;
        $this->url=$str3;
        $this->pages=intval($this->numrows/$this->pagesize);
        if($this->numrows%$this->pagesize){
            $this->pages++;
        }

        $nPage=$_GET['page'];
        if(isset($nPage)){
            $this->page=intval($nPage);
        }
        else{
            $this->page=1;
        }
        if($nPage<1||$nPage>$this->pages){
            $this->page=1;
        }//是用户想要跳转的页码
        $this->offset=$this->pagesize*($this->page-1);//这是从记录集中取出的行的首行，开端
    }
    function pageshow(){
        echo "第[".$this->page."/".$this->pages."]页";
        for($i==1;$i<=$this->pages;$i++){
            if($i==$this->page){
                echo "<span>".$i."</span>";
            }
            else{
                echo "<a href='".$this->url."=".$i."'>".$i."</a>";
            }
        }
    }
}
?>