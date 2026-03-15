document.addEventListener('DOMContentLoaded', function () {
    const upcInput = document.getElementById('upc-scan-box');
    const upcForm = document.getElementById('upc-form');
    const submitButton = document.getElementById('note-submit-button');


    const sessionIdEl = document.getElementById('session-id');
    const orderNumberEl = document.getElementById('order-number');
    

    const scanData = {}; // Object to hold the scan data for each UPC { "upc": upc}

    function updateScanDataFromTableRow(upc, scannedQty) {
        scanData[upc] = scannedQty;
    }

    function getRows() { 
        return document.querySelectorAll('#order-content-table tr'); 
    }

    //===========Plus Button Processing================[TOP]//
    const plusButtonLoop = document.querySelectorAll('.add-button');

    plusButtonLoop.forEach(function(button) {
        button.addEventListener('click', function () {
            //Get the row
            let row = this.closest('tr');
            let upc = row.querySelector('.upc');
            let expected = row.querySelector('.expected');
            let scannedQty = row.querySelector('.scanned');
            fullCell = row.querySelector('.full-checked');
            statusCheckedDB = row.querySelector('.full-checked');

            let upcRow = upc.textContent.trim();
            let expectedQty = parseInt(expected.textContent.trim());
            let currentScannedQty = parseInt(scannedQty.textContent.trim());

            // if (currentScannedQty > expectedQty) {
            //     alert("No");
            // }

            if (currentScannedQty < expectedQty) {
                currentScannedQty++;
                scannedQty.textContent = currentScannedQty;
            } else {
                alert("All items with this UPC have already been scanned.");
            }

            if (currentScannedQty === expectedQty) {
                fullCell.innerHTML = "<i class='fa fa-circle-check' style='color: rgb(2, 187, 2);'></i>";
            }

            if (currentScannedQty > 0) {
                if (currentScannedQty !== expectedQty) {
                    statusCheckedDB.innerHTML = "<i class='fas fa-box-open' style='color: darkorange;'></i>"
                }

                if (currentScannedQty < expectedQty) {
                    scannedQty.style.color = "blue";
                }

            }

            updateScanDataFromTableRow(upcRow, currentScannedQty);
        })

    });
    //===========Plus Button Processing================[BOTTOM]//

    async function submitAllScans() {
        const session_id = sessionIdEl ? parseInt(sessionIdEl.value, 10) : 0;
        const order_number = orderNumberEl ? orderNumberEl.value.trim() : "";

        if (!session_id || !order_number) {
            alert("Missing session_id / order_number. Please check hidden inputs in index.php.");
            return;
        }

        // if (Object.keys(scanData).length === 0) {
        //     alert("No scans to submit.");
        //     return;
        // }

        try {
            const res = await fetch('./backend/save_scans.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    session_id,
                    order_number,
                    scans: scanData
                })
            });

            const data = await res.json();

            if (data.status === "success") {
                alert("Submitted successfully!");
            } else {
                console.error(data);
                alert("Submit failed: " + (data.message || "Unknown error"));
            }
        } catch (err) {
            console.error(err);
            alert("Submit error. Check console.");
        }
    }

    upcForm.addEventListener('submit', function (e) {
        e.preventDefault();

        var upcValue = upcInput.value.trim();

        if (upcValue === "") return;
        found = false;

        const rows = getRows();
        for (var i = 0; i < rows.length; i++) {
            var upcCell = rows[i].querySelector('td.upc');

            if (!upcCell) continue;

            const rowUpc = upcCell.textContent.trim();


            if (rowUpc === upcValue) {
                found = true;
                expectedQtyCell = rows[i].querySelector('td.expected');
                scannedQtyCell = rows[i].querySelector('td.scanned');
                fullCell = rows[i].querySelector('td.full-checked');
                statusCheckedDB = rows[i].querySelector('td.full-checked');

                var expectedQty = parseInt(expectedQtyCell.textContent.trim(), 10);
                var scannedQty = parseInt(scannedQtyCell.textContent.trim(), 10);

                if (scannedQty < expectedQty) {
                    scannedQty += 1;
                    scannedQtyCell.textContent = scannedQty
                    if (scannedQty === expectedQty) {
                        fullCell.innerHTML = "<i class='fa fa-circle-check' style='color: rgb(2, 187, 2);'></i>";
                    }

                    if (scannedQty > 0) {
                        if (scannedQty !== expectedQty) {
                            statusCheckedDB.innerHTML = "<i class='fas fa-box-open' style='color: darkorange;'></i>"
                        }

                        if (scannedQty <= expectedQty) {
                            scannedQtyCell.style.color = "blue";
                        }

                    }

                    updateScanDataFromTableRow(rowUpc, scannedQty);
                } else {
                    alert("All items with this UPC have already been scanned.");
                }


                break;
            }

        }
    
        if (!found) {
            alert("UPC not found in the expected items list.");
        }
        upcInput.value = "";
        upcInput.focus();
    });

    if (submitButton) {
        submitButton.addEventListener('click', submitAllScans);
    }

});