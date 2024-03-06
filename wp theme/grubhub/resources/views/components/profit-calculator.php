<?php

/**
 * Profit Calculator
 *
**/

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'pc_headline');
$align = call_user_func($field_or_subfield, 'headline_alignment');

?>



<section class="profit-calculator">
  <div class="row">
    <div class="columns">
      <h2 class="<?php echo $align; ?>"><?php echo $headline; ?></h2>
    </div>
  </div>
  <div class="row align-justify">
    <div class="columns large-5 medium-12 small-12">
      <div class="form-wrap">
        <label for="daily-orders">Projected Daily Grubhub orders</label>
        <input type="number" step="1" min="1" id="daily-orders" class="standard" style="width: 89px; height: 38px;" onfocusout="x_Orders()">
      </div>
      <div class="form-wrap">
        <label for="average-ticket">Average Ticket <span class="text-muted small">($)</span>
          <small class="text-muted">The size of an average order at your restaurant</small>
        </label>
        <div class="input-group">
          <span class="input-group-label">$</span>
          <input type="number" step="0.01" min="0.01" class=" col-md-2" id="average-ticket">
        </div>
      </div>
      <div class="form-wrap">
        <label for="delivery-services">Use Grubhub Delivery services?
          <small class="text-muted">Payment for Grubhub Delivery Services only applies if you choose to take advantage of Grubhub Delivery.</small></label>
          <input type="radio" name="pc-radio" id="pc-yes" value="yes">
          <label for="pc-yes">Yes</label>
          <input type="radio" name="pc-radio" id="pc-no" value="no">
          <label for="pc-no">No</label>
        </div>
        <div class="form-wrap">
          <label for="food-cost">Food Percentage Cost
            <span class="text-muted small">(%)</span>
            <br>
            <small class="text-muted">Percentage of each order that goes toward covering the cost of food</small>
          </label>
          <div class="input-group">
            <span class="input-group-label">$</span>
            <input type="number" step="1" max="100" class="col-md-2" id="food-cost" onfocusout="x_Food_Cost()">
          </div>
        </div>
        <div class="form-wrap">
          <label for="labor-cost">Additional daily labor costs needed to fulfill <span class="x-orders"></span> incremental Grubhub daily orders: <br><small class="text-muted">Many restaurants find that they can fulfill a substantial number of additional Grubhub orders with their existing staff.</small></label>
          <div class="input-group">
            <span class="input-group-label">$</span>
            <input type="number" step="0.01" min="0.01" placeholder="0" class="col-md-2" id="labor-cost">
          </div>
        </div>
        <div class="form-wrap">
          <label for="add-overhead">Additional daily overhead needed to fulfill
            <span class="x-orders"></span> incremental Grubhub daily orders:
            <br>
            <small class="text-muted">Boost your orders without necessarily increasing your overhead costs. </small>
          </label>
          <div class="input-group">
            <span class="input-group-label">$</span>
            <input type="number" step="0.01" min="0.01" class=" col-md-2" placeholder="0" id="add-overhead">
          </div>
        </div>
        <div class="form-wrap">
          <a href="#/" class="button primary" role="button" id="pc-calculate">Calculate</a>
        </div>
      </div>
      <div class="columns large-6 medium-12 small-12">
        <h4>Projected Monthly Incremental Profit</h4>
        <div class="row align-justify">
          <div class="columns large-6">
            <div class="card">
              <div class="inc-head">Monthly</div>
              <h5 class="pc-mo"></h5>
            </div>
          </div>
          <div class="columns large-6">
            <div class="card">
              <div class="inc-head">Yearly</div>
              <h5 class="pc-yr"></h5>
            </div>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              <th class="fixed">The Breakdown</th>
              <th>Monthly</th>
              <th>Yearly</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="fixed">Projected Monthly Incremental Revenue<small class="text-muted"><span class="x-orders"></span> </small></td>
              <td id="pc-inc-rev-mo"></td>
              <td id="pc-inc-rev-yr"></td>
            </tr>
            <tr>
              <td class="fixed">Marketing fee <br> <small class="text-muted">(20%)</small></td>
              <td id="pc-mar-fee-mo"></td>
              <td id="pc-mar-fee-yr"></td>
            </tr>
            <tr>
              <td class="fixed">Delivery fee <br> <small class="text-muted">(10%)</small></td>
              <td id="pc-del-fee-mo"></td>
              <td id="pc-del-fee-yr"></td>
            </tr>
            <tr>
              <td class="fixed">Processing fee <br> <small class="text-muted">($0.30 + 3.05%)</small></td>
              <td id="pc-pro-fee-mo"></td>
              <td id="pc-pro-fee-yr"></td>
            </tr>
            <tr>
              <td class="fixed">Food Cost <br> <small class="text-muted x-food-cost"></small></td>
              <td id="pc-food-cost-mo"></td>
              <td id="pc-food-cost-yr"></td>
            </tr>
            <tr>
              <td class="fixed">Additional Staff</td>
              <td id="pc-add-staff-mo"></td>
              <td id="pc-add-staff-yr"></td>
            </tr>
            <tr>
              <td class="fixed">Additional Overhead</td>
              <td id="pc-add-over-mo"></td>
              <td id="pc-add-over-yr"></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th class="fixed">Projected Incremental net profit</th>
              <th class="pc-mo"></th>
              <th class="pc-yr"></th>
            </tr>
          </tfoot>
        </table>
        <div id="negative-disclaimer">
          <p>Many restaurants can see an increase in revenue and profit with minimal increases in fixed costs -- please check that you’ve completed all fields correctly. If you still have questions, contact our Sales team at 877-805-5081.</p>
        </div>
      </div>
    </div>
  </section>