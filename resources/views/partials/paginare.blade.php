<div class="paginare">
    @if($paginare>1)
        <ul class="pagination">  
            @if($paginare>7)
                @if($curentpage>3)
                    @if($curentpage+3<=$paginare)
                        <span style="display:none;">
                            {{$start=$curentpage-3}}
                            {{$end=$curentpage+3}}
                        </span>
                    @else
                        <span style="display:none;">
                            {{$start=$paginare-6}}
                            {{$end=$paginare}}
                        </span>
                    @endif
                @else
                    <span style="display:none;">
                        {{$start=1}}
                        {{$end=7}}
                    </span>
                @endif
            @else
                <span style="display:none;">
                    {{$start=1}}
                    {{$end=$paginare}}
                </span>
            @endif
            <li>
                <a href="{{URL("sort=".$link["sort"]."/[".$link[2]["address"]."]-".$link[2]["name"]."/page=1"."?".$url)}}">
                    <span class="glyphicon glyphicon-backward"></span>
                </a>
            </li>
            @for($i=$start;$i<=$end;$i++)
                @if($i==$curentpage)
                    <li class="active">
                        <a href="{{URL("sort=".$link["sort"]."/[".$link[2]["address"]."]-".$link[2]["name"]."/page=".$i."?".$url)}}">
                            {{$i}}
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{URL("sort=".$link["sort"]."/[".$link[2]["address"]."]-".$link[2]["name"]."/page=".$i."?".$url)}}">
                            {{$i}}
                        </a>
                    </li>
                @endif
            @endfor
            <li>
                <a href="{{URL("sort=".$link["sort"]."/[".$link[2]["address"]."]-".$link[2]["name"]."/page=".$paginare."?".$url)}}">
                    <span class="glyphicon glyphicon-forward"></span>
                </a>
            </li>
        </ul>
    @endif
</div>