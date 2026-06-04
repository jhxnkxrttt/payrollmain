<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Segoe UI',sans-serif;
            background:#f5f7fa;
            padding:40px;
            color:#2d3748;
        }

        .payslip{
            max-width:850px;
            margin:auto;
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 15px 35px rgba(0,0,0,.08);
        }

        .header{
            padding:30px 40px;
            border-bottom:1px solid #e2e8f0;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .company h1{
            font-size:28px;
            font-weight:700;
            color:#111827;
        }

        .company p{
            color:#64748b;
            margin-top:5px;
        }

        .payslip-title{
            text-align:right;
        }

        .payslip-title h2{
            font-size:32px;
            color:#0f172a;
        }

        .content{
            padding:35px 40px;
        }

        .employee-info{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:20px;
            margin-bottom:30px;
        }

        .info-card{
            background:#f8fafc;
            border:1px solid #e2e8f0;
            border-radius:12px;
            padding:18px;
        }

        .label{
            font-size:12px;
            text-transform:uppercase;
            color:#64748b;
            margin-bottom:6px;
        }

        .value{
            font-size:16px;
            font-weight:600;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        thead{
            background:#111827;
            color:white;
        }

        th{
            padding:14px;
            text-align:left;
            font-weight:600;
        }

        td{
            padding:14px;
            border-bottom:1px solid #e5e7eb;
        }

        td:last-child,
        th:last-child{
            text-align:right;
        }

        .deduction{
            color:#dc2626;
        }

        .summary{
            margin-top:25px;
            margin-left:auto;
            width:320px;
        }

        .salary-chart{
            margin-top:28px;
            padding:18px;
            border:1px solid #e2e8f0;
            border-radius:12px;
            background:#f8fafc;
        }

        .salary-chart h3{
            margin-bottom:4px;
            color:#0f172a;
            font-size:18px;
        }

        .salary-chart p{
            margin-bottom:14px;
            color:#64748b;
            font-size:12px;
        }

        .chart-caption{
            display:flex;
            justify-content:space-between;
            margin-top:10px;
            color:#64748b;
            font-size:11px;
        }

        .summary-row{
            display:flex;
            justify-content:space-between;
            padding:12px 0;
            border-bottom:1px solid #e5e7eb;
        }

        .net-pay{
            margin-top:15px;
            background:#111827;
            color:white;
            padding:18px 20px;
            border-radius:12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .net-pay span{
            font-size:14px;
            letter-spacing:1px;
        }

        .net-pay strong{
            font-size:24px;
        }

        .footer{
            padding:25px 40px;
            text-align:center;
            color:#94a3b8;
            border-top:1px solid #e2e8f0;
            font-size:13px;
        }
    </style>
</head>
<body>

<div class="payslip">

    <div class="header">
        <div class="company">
            <h1>Cafe Payroll System</h1>
            <p>Employee Payslip</p>
        </div>

        <div class="payslip-title">
            <h2>PAYSLIP</h2>
        </div>
    </div>

    <div class="content">

        <div class="employee-info">

            <div class="info-card">
                <div class="label">Employee Name</div>
                <div class="value">{{ $employee->name }}</div>
            </div>

            <div class="info-card">
                <div class="label">Position</div>
                <div class="value">{{ $employee->position }}</div>
            </div>

            <div class="info-card">
                <div class="label">Paid Date</div>
                <div class="value">{{ $payslip->paid_date }}</div>
            </div>

            <div class="info-card">
                <div class="label">Net Pay</div>
                <div class="value">
                    PHP {{ number_format($payslip->net_pay,2) }}
                </div>
            </div>

        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>Gross Pay</td>
                    <td>PHP {{ number_format($payslip->gross_pay,2) }}</td>
                </tr>

                <tr>
                    <td>Late Deduction</td>
                    <td class="deduction">
                        - PHP {{ number_format($payslip->late_deduction,2) }}
                    </td>
                </tr>

                @foreach($selectedDeductions as $d)
                <tr>
                    <td>{{ $d['type'] }}</td>
                    <td class="deduction">
                        - PHP {{ number_format($d['amount'],2) }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <div class="summary">

            <div class="summary-row">
                <span>Total Deductions</span>
                <strong>
                    PHP {{ number_format($payslip->total_deductions,2) }}
                </strong>
            </div>

            <div class="net-pay">
                <span>NET PAY</span>
                <strong>
                    PHP {{ number_format($payslip->net_pay,2) }}
                </strong>
            </div>

        </div>

        @php
            $chartValues = collect($salaryChart['values'] ?? []);
            $chartLabels = collect($salaryChart['labels'] ?? []);
            $maxValue = max((float) $chartValues->max(), 1);
            $chartWidth = 720;
            $chartHeight = 180;
            $plotTop = 18;
            $plotBottom = 150;
            $plotLeft = 28;
            $plotRight = 700;
            $pointCount = max($chartValues->count() - 1, 1);
            $points = $chartValues->values()->map(function ($value, $index) use ($maxValue, $plotTop, $plotBottom, $plotLeft, $plotRight, $pointCount) {
                $x = $plotLeft + (($plotRight - $plotLeft) * ($index / $pointCount));
                $y = $plotBottom - (($plotBottom - $plotTop) * ((float) $value / $maxValue));

                return round($x, 2) . ',' . round($y, 2);
            })->implode(' ');
        @endphp

        @if($chartValues->count())
            <div class="salary-chart">
                <h3>Salary Trend</h3>
                <p>Net pay history for {{ $employee->name }}</p>
                <svg width="100%" height="190" viewBox="0 0 720 190" xmlns="http://www.w3.org/2000/svg">
                    <line x1="28" y1="150" x2="700" y2="150" stroke="#cbd5e1" stroke-width="1"/>
                    <line x1="28" y1="18" x2="28" y2="150" stroke="#cbd5e1" stroke-width="1"/>
                    <polyline points="{{ $points }}" fill="none" stroke="#2563eb" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    @foreach(explode(' ', $points) as $point)
                        @php [$x, $y] = explode(',', $point); @endphp
                        <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="#ffffff" stroke="#2563eb" stroke-width="3"/>
                    @endforeach
                </svg>
                <div class="chart-caption">
                    <span>{{ $chartLabels->first() ?? 'Start' }}</span>
                    <strong>Highest: PHP {{ number_format($maxValue, 2) }}</strong>
                    <span>{{ $chartLabels->last() ?? 'Latest' }}</span>
                </div>
            </div>
        @endif

    </div>

    <div class="footer">
        Generated by Cafe Payroll Management System
    </div>

</div>

</body>
</html>
