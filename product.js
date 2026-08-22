// Raghad Alyabis 2240003458

function validateForm() {
    var qty = document.getElementById('quantity').value;

    if (qty === '' || isNaN(qty) || qty <= 0) {
        alert('Please enter a valid quantity (must be a positive number).');
        return false;
    }

    if (parseInt(qty) > productStock) {
        alert('Sorry, only ' + productStock + ' items available in stock.');
        return false;
    }

    return true;
}

function openHelp() {
    var helpWindow = window.open('', 'Help', 'width=400,height=300');

    helpWindow.document.write('<html><head><title>Help</title>');
    helpWindow.document.write('<style>body{font-family:Segoe UI,sans-serif;padding:20px;background:#FFF7CD;color:#333;}h2{color:#F57799;}p{line-height:1.8;}</style>');
    helpWindow.document.write('</head><body>');
    helpWindow.document.write('<h2>How to Order</h2>');
    helpWindow.document.write('<p>1. Enter the quantity you want.</p>');
    helpWindow.document.write('<p>2. Click "Add to Cart" button.</p>');
    helpWindow.document.write('<p>3. Go to Checkout to review your order.</p>');
    helpWindow.document.write('<p>4. Click "Buy" to complete your purchase.</p>');
    helpWindow.document.write('<br><button onclick="window.close()">Close</button>');
    helpWindow.document.write('</body></html>');
}