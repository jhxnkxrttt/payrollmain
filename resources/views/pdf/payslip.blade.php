<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; }
    </style>
</head>
<body>

<div class="container">

    <h2>Payslip</h2>

    <p><strong>Employee:</strong> {{ $employee->name }}</p>
    <p><strong>Paid Date:</strong> {{ $payslip->paid_date }}</p>

    <table>
        <tr>
            <td>Gross Pay</td>
            <td>PHP {{ number_format($payslip->gross_pay, 2) }}</td>
        </tr>

        <tr>
            <td>Late Deduction</td>
            <td>PHP {{ number_format($payslip->late_deduction, 2) }}</td>
        </tr>

        @foreach($selectedDeductions as $d)
        <tr>
            <td>{{ $d['type'] }}</td>
            <td>PHP {{ number_format($d['amount'], 2) }}</td>
        </tr>
        @endforeach

        <tr class="total">
            <td>Total Deductions</td>
            <td>PHP {{ number_format($payslip->total_deductions, 2) }}</td>
        </tr>

        <tr class="total">
            <td>Net Pay</td>
            <td>PHP {{ number_format($payslip->net_pay, 2) }}</td>
        </tr>

    </table>

</div>

</body>
</html>
