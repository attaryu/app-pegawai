<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $salary->bulan }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }

        .slip-title {
            font-size: 18px;
            color: #666;
            margin-top: 10px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 4px;
        }

        .info-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .salary-table th {
            background-color: #2563eb;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }

        .salary-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .salary-table tr:last-child td {
            border-bottom: none;
        }

        .amount {
            text-align: right;
            font-weight: 600;
        }

        .positive {
            color: #059669;
        }

        .negative {
            color: #dc2626;
        }

        .total-row {
            background-color: #eff6ff;
            font-weight: bold;
            font-size: 16px;
        }

        .total-row td {
            padding: 15px 12px;
            color: #2563eb;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }

        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 60px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 5px;
            font-size: 12px;
            color: #666;
        }

        .print-date {
            text-align: right;
            font-size: 11px;
            color: #999;
            margin-top: 20px;
        }

        .note {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin-top: 20px;
            font-size: 12px;
            color: #92400e;
        }
    </style>
</head>
<body>
    @php
        $format = fn(float $value) => 'Rp ' . number_format($value, 0, ',', '.');
    @endphp

    <!-- Header -->
    <div class="header">
        <div class="company-name">APP PEGAWAI</div>
        <div style="font-size: 12px; color: #666;">Employee Management System</div>
        <div class="slip-title">SALARY SLIP</div>
    </div>

    <!-- Employee Information -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Employee Name</div>
                <div class="info-value">{{ $employee->nama_lengkap }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Employee ID</div>
                <div class="info-value">#EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $employee->department->nama_departemen ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Position</div>
                <div class="info-value">{{ $employee->position->nama_jabatan ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Pay Period</div>
                <div class="info-value">{{ $salary->bulan }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Payment Date</div>
                <div class="info-value">{{ now()->format('d F Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Salary Details -->
    <table class="salary-table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Base Salary</td>
                <td class="amount">{{ $format($salary->gaji_pokok) }}</td>
            </tr>
            <tr>
                <td class="positive">Allowance (+)</td>
                <td class="amount positive">{{ $format($salary->gaji_tunjangan) }}</td>
            </tr>
            <tr>
                <td style="padding-bottom: 20px;"></td>
                <td style="padding-bottom: 20px;"></td>
            </tr>
            <tr>
                <td><strong>Gross Salary</strong></td>
                <td class="amount"><strong>{{ $format($salary->gaji_pokok + $salary->gaji_tunjangan) }}</strong></td>
            </tr>
            <tr>
                <td style="padding-bottom: 20px;"></td>
                <td style="padding-bottom: 20px;"></td>
            </tr>
            <tr>
                <td class="negative">Deduction (-)</td>
                <td class="amount negative">{{ $format($salary->potongan) }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>NET SALARY</strong></td>
                <td class="amount"><strong>{{ $format($salary->total_gaji) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Note -->
    <div class="note">
        <strong>Note:</strong> This is a computer-generated salary slip and does not require a signature.
        Please keep this document for your records. For any discrepancies, please contact the HR department.
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    Employee Signature
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    Authorized Signature
                </div>
            </div>
        </div>

        <div class="print-date">
            Generated on: {{ now()->format('d F Y, H:i:s') }}
        </div>
    </div>
</body>
</html>
