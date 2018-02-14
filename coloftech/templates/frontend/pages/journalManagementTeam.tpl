<div class="slider">

 {if $managementteam}
    <div class="row">
        <div class="row">
            <div class="col-md-9">
                
                <h3>
                   Journal Management Team <span style="font-size:9px; ">Total ({$managementteam|@count})</span></h3>
            </div>
            <div class="col-md-3">

            {if $managementteam|@count gt 4} 
                <!-- Controls -->
                <div class="controls pull-right hidden-xs">
                    <a class="left fa fa-chevron-left btn btn-primary" href="#managementTeam"
                        data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-primary" href="#managementTeam"
                            data-slide="next"></a>
                </div>
            {/if}
            </div>

        </div>
        <div id="managementTeam" class="carousel slide hidden-xs" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">

             {$managementdata}


            </div>
        </div>
    </div> <!-- end of slider-->

         {/if}


</div>
