export default {
  init() {
    let negativeDisclaimer = document.getElementById('negative-disclaimer');
    let psCalculate = document.getElementById('pc-calculate'); //button
    let dailyOrders = document.getElementById('daily-orders');
    let averageTicket = document.getElementById('average-ticket');
    let pcRadio = document.getElementsByName('pc-radio');
    let foodCost = document.getElementById('food-cost');
    let laborCost = document.getElementById('labor-cost');
    let additionalOverhead = document.getElementById('add-overhead');
    let moTotal = 0;
    let yrTotal = 0;
    let xOrders = document.getElementsByClassName('x-orders');
    let xFoodCost = document.getElementsByClassName('x-food-cost');
    let xDelFee = document.getElementsByClassName('del-Fee');
    let pcNo = document.getElementById('pc-no');

    window.x_Food_Cost = function() {
      for (let i = 0; i < xFoodCost.length; i++) {
        xFoodCost[i].innerText = "(" + foodCost.value + "% of Average Order)";
      }
    }

    window.x_Orders = function() {
      for (let i = 0; i < xOrders.length; i++) {
        xOrders[i].innerText = "" + dailyOrders.value + "";
      }
    }

    psCalculate.addEventListener("click", (e) => {
      //incremental revenue
      let incMo = parseFloat((dailyOrders.value * averageTicket.value) * 30);
      let incYr = parseFloat((dailyOrders.value * averageTicket.value) * 365);
      //let incYr = parseFloat(incMo * 12);
      document.getElementById('pc-inc-rev-mo').innerText = "$" + incMo.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      document.getElementById('pc-inc-rev-yr').innerText = "$" + incYr.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      //Marketing fee
      let marMo = parseFloat((dailyOrders.value * averageTicket.value * 0.20) * 30);
      let marYr = parseFloat((dailyOrders.value * averageTicket.value * 0.20) * 365);
      //let marYr = parseFloat(marMo * 12);
      document.getElementById('pc-mar-fee-mo').innerText = "-$" + marMo.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      document.getElementById('pc-mar-fee-yr').innerText = "-$" + marYr.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      //Delivery fee
      let delMo = parseFloat((dailyOrders.value * averageTicket.value * 0.10) * 30);
      let delYr = parseFloat((dailyOrders.value * averageTicket.value * 0.10) * 365);

      if(pcNo.checked){
       delMo = parseFloat(0); 
       delYr = parseFloat(0); 
       for (let i = 0; i < xDelFee.length; i++) {
        xDelFee[i].innerText = "(" + 0 + "%)";
      }
    }

    document.getElementById('pc-del-fee-mo').innerText = "-$" + delMo.toLocaleString(
      undefined, {
        minimumFractionDigits: 2,
      }
      );

    document.getElementById('pc-del-fee-yr').innerText = "-$" + delYr.toLocaleString(
      undefined, {
        minimumFractionDigits: 2,
      }
      );

      //Processing fee
      let proMo = parseFloat((dailyOrders.value * averageTicket.value * 0.0305 + (dailyOrders.value * 0.30)) * 30);
      let proYr = parseFloat((dailyOrders.value * averageTicket.value * 0.0305 + (dailyOrders.value * 0.30)) * 365);
      //let proYr = parseFloat(proMo * 12).toFixed(2);
      document.getElementById('pc-pro-fee-mo').innerText = "-$" + proMo.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      document.getElementById('pc-pro-fee-yr').innerText = "-$" + proYr.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      //Food cost
      let foodMo = parseFloat((dailyOrders.value * averageTicket.value * (foodCost.value / 100) * 30));
      let foodYr = parseFloat((dailyOrders.value * averageTicket.value * (foodCost.value / 100) * 365));
      //let foodYr = parseFloat(foodMo * 12);
      document.getElementById('pc-food-cost-mo').innerText = "-$" + foodMo.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      document.getElementById('pc-food-cost-yr').innerText = "-$" + foodYr.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      //additional staff
      let laborMo = parseFloat(laborCost.value * 30) || 0;
      let laborYr = parseFloat(laborCost.value * 365) || 0;
      document.getElementById('pc-add-staff-mo').innerText = "-$" + laborMo.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      document.getElementById('pc-add-staff-yr').innerText = "-$" + laborYr.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      //additional overhead
      let overMo = parseFloat(additionalOverhead.value * 30) || 0;
      let overYr = parseFloat(additionalOverhead.value * 365) || 0;
      document.getElementById('pc-add-over-mo').innerText = "-$" + overMo.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      document.getElementById('pc-add-over-yr').innerText = "-$" + overYr.toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      //Totals
      const moTotal = parseFloat(incMo - marMo - delMo - proMo - foodMo - laborMo - overMo).toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      const yrTotal = parseFloat(incYr - marYr - delYr - proYr - foodYr - laborYr - overYr).toLocaleString(
        undefined, {
          minimumFractionDigits: 2,
        }
        );

      const moItems = document.getElementsByClassName('pc-mo');
      const yrItems = document.getElementsByClassName('pc-yr');

      for (let i = 0; i < moItems.length; i++) {
        moItems[i].innerText = "$" + moTotal;
      }

      for (let i = 0; i < yrItems.length; i++) {
        yrItems[i].innerText = "$" + yrTotal;
      }

      console.log(Math.sign(parseFloat(moTotal))); 

      if (Math.sign(parseFloat(moTotal)) == -1 || Math.sign(parseFloat(yrTotal)) == -1) {
        negativeDisclaimer.style.display = "block";
        return false;
      }

    });

},
finalize() {
},
};
