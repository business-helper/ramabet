<template>
    <aside id="rightsidebar" class="right-sidebar" style="padding:10px;margin-top: 20px;overflow: auto;">
        <balance></balance>
        <div id="tabs" style="height: 78%;">
            <ul class="nav nav-tabs" id="myTab">
                <li class="betslipe_tab active">
                    <a data-toggle="tab" href="#betsipe">Bet slip</a>
                </li>
                <li class="open_bets_tab">
                    <a data-toggle="tab" href="#openbet">Open Bets</a>
                </li>
            </ul>
            <div class="tab-content" style="background-color: white;
    min-height: 100px;overflow-y: auto;height: 100%">
                <betslip></betslip>
                <div id="openbet" class="tab-pane fade">
                    <label>
                        <input type="checkbox" data-ng-model="$parent.Showbetslipdetails"
                               data-ng-click="Showbetslipdetailsfn()"
                               class="ng-pristine ng-untouched ng-empty ng-valid">Show bet Info </label>
                    <!--<a for="collapseTwo" data-toggle="collapse" href="#collapseTwo" aria-expanded="true"
                       aria-controls="collapseTwo" class="btn toggleable-list-title"
                       style="width: 100%;background-color: #06446c;color: #fff;border-radius: 0;padding: 0;">
                    <span style="font-size: 12px; font-weight: 700;">
                        <strong>Unmatched Bets</strong>
                        &lt;!&ndash;<span class="value ng-binding">100.00</span>&ndash;&gt;
                    </span>
                        <span class="arrow"><i class="fas"></i></span>
                    </a>-->
                    <!--<div id="collapseTwo" class="placedbets collapse in show"
                         style="background: rgb(255, 255, 255);  font-size: 12px;">
                        &lt;!&ndash;<placedbets time_status="0"></placedbets>&ndash;&gt;
                    </div>-->
                    <a for="collapseThree" data-toggle="collapse" href="#collapseThree" aria-expanded="true"
                       aria-controls="collapseTwo" class="btn toggleable-list-title"
                       style="width: 100%;background-color: #06446c;color: #fff;border-radius: 0;padding: 0;">
                    <span style="font-size: 12px; font-weight: 700;">
                        <strong>Matched Bets</strong>
                        <!--<span class="value ng-binding">100.00</span>-->
                    </span>
                        <span class="arrow"><i class="fas"></i></span>
                    </a>
                    <div id="collapseThree" class="placedbets collapse in show"
                         style="background: rgb(255, 255, 255); font-size: 12px;">
                        <placedbets time_status="1"></placedbets>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
