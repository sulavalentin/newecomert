<div class="sortare col-lg-3 col-md-3 col-sm-12 col-xs-12">
    @if(!empty($link))
        <form id="sortare" action="{{URL("sort=".$link["sort"]."/[".$link["2"]["address"]."]-".$link["2"]["name"]."/page=1")}}">
            @if(!empty($sortare["selected"]) && !empty($link))
                <p><b>Filtre alese:</b></p>
                @foreach($sortare["selected"] as $key => $sort)
                        <p style="color:gray;margin-top: 10px;"><b>{{$key}}</b></p>
                        @foreach($sort as $i)
                            <label for="sort{{$i->value}}" class="noselect sortlabel">
                                <input type="checkbox" id="sort{{$i->value}}" 
                                       class="compara" 
                                       value="{{$i->idspec}}" 
                                       name="{{$i->id}}"
                                       checked/>
                                <span>{{$i->value}}</span>
                            </label>
                            <br>
                        @endforeach
                @endforeach
                <hr style="margin: 10px 0px;">
            @endif
            @if(!empty($sortare["noselected"]))
                @foreach($sortare["noselected"] as $key => $sort)
                    <div class="sort_group">
                       <p><b>{{$key}}</b></p>
                       @foreach($sort as $i)
                           <label for="sort{{$i->value}}" class="noselect sortlabel">
                                <input type="checkbox" id="sort{{$i->value}}" 
                                       class="compara" 
                                       value="{{$i->idspec}}" 
                                       name="{{$i->id}}"/>
                                <span>{{$i->value}}</span>
                            </label>
                           <br>
                       @endforeach
                    </div>
                @endforeach
            @endif
        </form>
    @endif
</div>