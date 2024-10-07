<head>
    <title>NXG App</title>
    <script src="../assets/lib/jquery/jquery-3.6.0.min.js"></script>
    <link href="../assets/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/lib/bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/on-load.js"></script>
    <script src="../assets/main.js"></script>
    <style>
        th, td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        label[for='dt-search-0'] {
            display: none;
        }

        .dt-layout-row:nth-child(1) {
            display: flex !important;
            flex-direction: row-reverse;
            justify-content: start;
            align-items: center;
        }

        .dt-end {
            margin-right: 20px;
        }

        .dt-length label {
            display: none;
        }

        .dt-search input {
            padding: 5px 10px !important;
        }
    </style>
</head>