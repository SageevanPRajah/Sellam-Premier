@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Select Your Seats</h1>

    <!-- Seat Type Selection -->
    <div id="seat-types">
        <h3>Select Seat Type</h3>
        <button class="button" data-type="Silver">Silver</button>
        <button class="button" data-type="Gold">Gold</button>
        <button class="button" data-type="Platinum">Platinum</button>
    </div>

    <!-- Theater Layout -->
    <div id="theater-layout">
        <!-- Silver Section -->
        <div class="seat-type-layout-section" id="silver-layout" style="display: none;">
            <table>
                <thead>
                    <tr>
                        <th colspan="14">Silver Class</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SL</td>
                        <td><button class="seat available" data-seat-code="S-SL-1">SL1</button></td>
                        <td><button class="seat available" data-seat-code="S-SL-2">SL2</button></td>
                        <td><button class="seat available" data-seat-code="S-SL-3">SL3</button></td>
                        <td><button class="seat available" data-seat-code="S-SL-4">SL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-SR-5">SR5</button></td>
                        <td><button class="seat available" data-seat-code="S-SR-6">SR6</button></td>
                        <td><button class="seat available" data-seat-code="S-SR-7">SR7</button></td>
                        <td><button class="seat available" data-seat-code="S-SR-8">SR8</button></td>
                        <td><button class="seat available" data-seat-code="S-SR-9">SR9</button></td>
                        <td><button class="seat available" data-seat-code="S-SR-10">SR10</button></td>
                        <td>SR</td>
                    </tr>
                    <tr>
                        <td>RL</td>
                        <td><button class="seat available" data-seat-code="S-RL-1">RL1</button></td>
                        <td><button class="seat available" data-seat-code="S-RL-2">RL2</button></td>
                        <td><button class="seat available" data-seat-code="S-RL-3">RL3</button></td>
                        <td><button class="seat available" data-seat-code="S-RL-4">RL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-RR-5">RR5</button></td>
                        <td><button class="seat available" data-seat-code="S-RR-6">RR6</button></td>
                        <td><button class="seat available" data-seat-code="S-RR-7">RR7</button></td>
                        <td><button class="seat available" data-seat-code="S-RR-8">RR8</button></td>
                        <td><button class="seat available" data-seat-code="S-RR-9">RR9</button></td>
                        <td><button class="seat available" data-seat-code="S-RR-10">RR10</button></td>
                        <td>RR</td>
                    </tr>
                    <tr>
                        <td>QL</td>
                        <td><button class="seat available" data-seat-code="S-QL-1">QL1</button></td>
                        <td><button class="seat available" data-seat-code="S-QL-2">QL2</button></td>
                        <td><button class="seat available" data-seat-code="S-QL-3">QL3</button></td>
                        <td><button class="seat available" data-seat-code="S-QL-4">QL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-QR-5">QR5</button></td>
                        <td><button class="seat available" data-seat-code="S-QR-6">QR6</button></td>
                        <td><button class="seat available" data-seat-code="S-QR-7">QR7</button></td>
                        <td><button class="seat available" data-seat-code="S-QR-8">QR8</button></td>
                        <td><button class="seat available" data-seat-code="S-QR-9">QR9</button></td>
                        <td><button class="seat available" data-seat-code="S-QR-10">QR10</button></td>
                        <td>QR</td>
                    </tr>
                    <tr>
                        <td>PL</td>
                        <td><button class="seat available" data-seat-code="S-PL-1">PL1</button></td>
                        <td><button class="seat available" data-seat-code="S-PL-2">PL2</button></td>
                        <td><button class="seat available" data-seat-code="S-PL-3">PL3</button></td>
                        <td><button class="seat available" data-seat-code="S-PL-4">PL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-PR-5">PR5</button></td>
                        <td><button class="seat available" data-seat-code="S-PR-6">PR6</button></td>
                        <td><button class="seat available" data-seat-code="S-PR-7">PR7</button></td>
                        <td><button class="seat available" data-seat-code="S-PR-8">PR8</button></td>
                        <td><button class="seat available" data-seat-code="S-PR-9">PR9</button></td>
                        <td><button class="seat available" data-seat-code="S-PR-10">PR10</button></td>
                        <td>PR</td>
                    </tr>
                    <tr>
                        <td>OL</td>
                        <td><button class="seat available" data-seat-code="S-OL-1">OL1</button></td>
                        <td><button class="seat available" data-seat-code="S-OL-2">OL2</button></td>
                        <td><button class="seat available" data-seat-code="S-OL-3">OL3</button></td>
                        <td><button class="seat available" data-seat-code="S-OL-4">OL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-OR-5">OR5</button></td>
                        <td><button class="seat available" data-seat-code="S-OR-6">OR6</button></td>
                        <td><button class="seat available" data-seat-code="S-OR-7">OR7</button></td>
                        <td><button class="seat available" data-seat-code="S-OR-8">OR8</button></td>
                        <td><button class="seat available" data-seat-code="S-OR-9">OR9</button></td>
                        <td><button class="seat available" data-seat-code="S-OR-10">OR10</button></td>
                        <td>OR</td>
                    </tr>
                    <tr>
                        <td>NL</td>
                        <td><button class="seat available" data-seat-code="S-NL-1">NL1</button></td>
                        <td><button class="seat available" data-seat-code="S-NL-2">NL2</button></td>
                        <td><button class="seat available" data-seat-code="S-NL-3">NL3</button></td>
                        <td><button class="seat available" data-seat-code="S-NL-4">NL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-NR-5">NR5</button></td>
                        <td><button class="seat available" data-seat-code="S-NR-6">NR6</button></td>
                        <td><button class="seat available" data-seat-code="S-NR-7">NR7</button></td>
                        <td><button class="seat available" data-seat-code="S-NR-8">NR8</button></td>
                        <td><button class="seat available" data-seat-code="S-NR-9">NR9</button></td>
                        <td><button class="seat available" data-seat-code="S-NR-10">NR10</button></td>
                        <td>NR</td>
                    </tr>
                    <tr>
                        <td>ML</td>
                        <td><button class="seat available" data-seat-code="S-ML-1">ML1</button></td>
                        <td><button class="seat available" data-seat-code="S-ML-2">ML2</button></td>
                        <td><button class="seat available" data-seat-code="S-ML-3">ML3</button></td>
                        <td><button class="seat available" data-seat-code="S-ML-4">ML4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-MR-5">MR5</button></td>
                        <td><button class="seat available" data-seat-code="S-MR-6">MR6</button></td>
                        <td><button class="seat available" data-seat-code="S-MR-7">MR7</button></td>
                        <td><button class="seat available" data-seat-code="S-MR-8">MR8</button></td>
                        <td><button class="seat available" data-seat-code="S-MR-9">MR9</button></td>
                        <td><button class="seat available" data-seat-code="S-MR-10">MR10</button></td>
                        <td>MR</td>
                    </tr>
                    <tr>
                        <td>LL</td>
                        <td><button class="seat available" data-seat-code="S-LL-1">LL1</button></td>
                        <td><button class="seat available" data-seat-code="S-LL-2">LL2</button></td>
                        <td><button class="seat available" data-seat-code="S-LL-3">LL3</button></td>
                        <td><button class="seat available" data-seat-code="S-LL-4">LL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-LR-5">LR5</button></td>
                        <td><button class="seat available" data-seat-code="S-LR-6">LR6</button></td>
                        <td><button class="seat available" data-seat-code="S-LR-7">LR7</button></td>
                        <td><button class="seat available" data-seat-code="S-LR-8">LR8</button></td>
                        <td><button class="seat available" data-seat-code="S-LR-9">LR9</button></td>
                        <td><button class="seat available" data-seat-code="S-LR-10">LR10</button></td>
                        <td>LR</td>
                    </tr>
                    <tr>
                        <td>KL</td>
                        <td><button class="seat available" data-seat-code="S-KL-1">KL1</button></td>
                        <td><button class="seat available" data-seat-code="S-KL-2">KL2</button></td>
                        <td><button class="seat available" data-seat-code="S-KL-3">KL3</button></td>
                        <td><button class="seat available" data-seat-code="S-KL-4">KL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-KR-5">KR5</button></td>
                        <td><button class="seat available" data-seat-code="S-KR-6">KR6</button></td>
                        <td><button class="seat available" data-seat-code="S-KR-7">KR7</button></td>
                        <td><button class="seat available" data-seat-code="S-KR-8">KR8</button></td>
                        <td><button class="seat available" data-seat-code="S-KR-9">KR9</button></td>
                        <td><button class="seat available" data-seat-code="S-KR-10">KR10</button></td>
                        <td>KR</td>
                    </tr>
                    <tr>
                        <td>JL</td>
                        <td><button class="seat available" data-seat-code="S-JL-1">JL1</button></td>
                        <td><button class="seat available" data-seat-code="S-JL-2">JL2</button></td>
                        <td><button class="seat available" data-seat-code="S-JL-3">JL3</button></td>
                        <td><button class="seat available" data-seat-code="S-JL-4">JL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-JR-5">JR5</button></td>
                        <td><button class="seat available" data-seat-code="S-JR-6">JR6</button></td>
                        <td><button class="seat available" data-seat-code="S-JR-7">JR7</button></td>
                        <td><button class="seat available" data-seat-code="S-JR-8">JR8</button></td>
                        <td><button class="seat available" data-seat-code="S-JR-9">JR9</button></td>
                        <td><button class="seat available" data-seat-code="S-JR-10">JR10</button></td>
                        <td>JR</td>
                    </tr>
                    <tr>
                        <td>IL</td>
                        <td><button class="seat available" data-seat-code="S-IL-1">IL1</button></td>
                        <td><button class="seat available" data-seat-code="S-IL-2">IL2</button></td>
                        <td><button class="seat available" data-seat-code="S-IL-3">IL3</button></td>
                        <td><button class="seat available" data-seat-code="S-IL-4">IL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-IR-5">IR5</button></td>
                        <td><button class="seat available" data-seat-code="S-IR-6">IR6</button></td>
                        <td><button class="seat available" data-seat-code="S-IR-7">IR7</button></td>
                        <td><button class="seat available" data-seat-code="S-IR-8">IR8</button></td>
                        <td><button class="seat available" data-seat-code="S-IR-9">IR9</button></td>
                        <td><button class="seat available" data-seat-code="S-IR-10">IR10</button></td>
                        <td>IR</td>
                    </tr>
                    <tr>
                        <td>HL</td>
                        <td><button class="seat available" data-seat-code="S-HL-1">HL1</button></td>
                        <td><button class="seat available" data-seat-code="S-HL-2">HL2</button></td>
                        <td><button class="seat available" data-seat-code="S-HL-3">HL3</button></td>
                        <td><button class="seat available" data-seat-code="S-HL-4">HL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-HR-5">HR5</button></td>
                        <td><button class="seat available" data-seat-code="S-HR-6">HR6</button></td>
                        <td><button class="seat available" data-seat-code="S-HR-7">HR7</button></td>
                        <td><button class="seat available" data-seat-code="S-HR-8">HR8</button></td>
                        <td><button class="seat available" data-seat-code="S-HR-9">HR9</button></td>
                        <td><button class="seat available" data-seat-code="S-HR-10">HR10</button></td>
                        <td>HR</td>
                    </tr>
                    <tr>
                        <td>GL</td>
                        <td><button class="seat available" data-seat-code="S-GL-1">GL1</button></td>
                        <td><button class="seat available" data-seat-code="S-GL-2">GL2</button></td>
                        <td><button class="seat available" data-seat-code="S-GL-3">GL3</button></td>
                        <td><button class="seat available" data-seat-code="S-GL-4">GL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-GR-5">GR5</button></td>
                        <td><button class="seat available" data-seat-code="S-GR-6">GR6</button></td>
                        <td><button class="seat available" data-seat-code="S-GR-7">GR7</button></td>
                        <td><button class="seat available" data-seat-code="S-GR-8">GR8</button></td>
                        <td><button class="seat available" data-seat-code="S-GR-9">GR9</button></td>
                        <td><button class="seat available" data-seat-code="S-GR-10">GR10</button></td>
                        <td>GR</td>
                    </tr>
                    <tr>
                        <td>FL</td>
                        <td><button class="seat available" data-seat-code="S-FL-1">FL1</button></td>
                        <td><button class="seat available" data-seat-code="S-FL-2">FL2</button></td>
                        <td><button class="seat available" data-seat-code="S-FL-3">FL3</button></td>
                        <td><button class="seat available" data-seat-code="S-FL-4">FL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-FR-5">FR5</button></td>
                        <td><button class="seat available" data-seat-code="S-FR-6">FR6</button></td>
                        <td><button class="seat available" data-seat-code="S-FR-7">FR7</button></td>
                        <td><button class="seat available" data-seat-code="S-FR-8">FR8</button></td>
                        <td><button class="seat available" data-seat-code="S-FR-9">FR9</button></td>
                        <td><button class="seat available" data-seat-code="S-FR-10">FR10</button></td>
                        <td>FR</td>
                    </tr>
                    <tr>
                        <td>EL</td>
                        <td><button class="seat available" data-seat-code="S-EL-1">EL1</button></td>
                        <td><button class="seat available" data-seat-code="S-EL-2">EL2</button></td>
                        <td><button class="seat available" data-seat-code="S-EL-3">EL3</button></td>
                        <td><button class="seat available" data-seat-code="S-EL-4">EL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-ER-5">ER5</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-6">ER6</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-7">ER7</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-8">ER8</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-9">ER9</button></td>
                        <td><button class="seat available" data-seat-code="S-ER-10">ER10</button></td>
                        <td>ER</td>
                    </tr>
                    <tr>
                        <td>DL</td>
                        <td><button class="seat available" data-seat-code="S-DL-1">DL1</button></td>
                        <td><button class="seat available" data-seat-code="S-DL-2">DL2</button></td>
                        <td><button class="seat available" data-seat-code="S-DL-3">DL3</button></td>
                        <td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="S-DR-4">DR4</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-5">DR5</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-6">DR6</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-7">DR7</button></td>
                        <td><button class="seat available" data-seat-code="S-DR-8">DR8</button></td>
                        <td>DR</td>
                    </tr>
                    <tr>
                        <td>CL</td>
                        <td><button class="seat available" data-seat-code="S-CL-1">CL1</button></td>
                        <td><button class="seat available" data-seat-code="S-CL-2">CL2</button></td>
                        <td><button class="seat available" data-seat-code="S-CL-3">CL3</button></td>
                        <td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-CR-4">CR4</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-CR-5">CR5</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-CR-6">CR6</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-CR-7">CR7</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-CR-8">CR8</button></td>
                        <td>CR</td>
                    </tr>
                    <tr>
                        <td>BL</td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BL-1">BL1</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BL-2">BL2</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BL-3">BL3</button></td>
                        <td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BR-4">BR4</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BR-5">BR5</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BR-6">BR6</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BR-7">BR7</button></td>
                        <td><button class="seat available" data-seat-codeseat-codeseat-code="S-BR-8">BR8</button></td>
                        <td>BR</td>
                    </tr>
                    <tr>
                        <td>AL</td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AL-1">AL1</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AL-2">AL2</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AL-3">AL3</button></td>
                        <td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AR-4">AR4</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AR-5">AR5</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AR-6">AR6</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AR-7">AR7</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="S-AR-8">AR8</button></td>
                        <td>AR</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Gold Section -->
        <div class="seat-type-layout-section" id="gold-layout" style="display: none;">
            <table>
                <thead>
                    <tr>
                        <th colspan="14">Gold Class</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>EL</td>
                        <td><button class="seat available" data-seat-code="G-EL-1">EL1</button></td>
                        <td><button class="seat available" data-seat-code="G-EL-2">EL2</button></td>
                        <td><button class="seat available" data-seat-code="G-EL-3">EL3</button></td>
                        <td><button class="seat available" data-seat-code="G-EL-4">EL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="G-ER-5">ER5</button></td>
                        <td><button class="seat available" data-seat-code="G-ER-6">ER6</button></td>
                        <td><button class="seat available" data-seat-code="G-ER-7">ER7</button></td>
                        <td><button class="seat available" data-seat-code="G-ER-8">ER8</button></td>
                        <td><button class="seat available" data-seat-code="G-ER-9">ER9</button></td>
                        <td><button class="seat available" data-seat-code="G-ER-10">ER10</button></td>
                        <td>ER</td>
                    </tr>
                    <tr>
                        <td>DL</td>
                        <td><button class="seat available" data-seat-code="G-DL-1">DL1</button></td>
                        <td><button class="seat available" data-seat-code="G-DL-2">DL2</button></td>
                        <td><button class="seat available" data-seat-code="G-DL-3">DL3</button></td>
                        <td><button class="seat available" data-seat-code="G-DL-4">DL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-codeseat-code="G-DR-5">DR5</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="G-DR-6">DR6</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="G-DR-7">DR7</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="G-DR-8">DR8</button></td>
                        <td><button class="seat available" data-seat-codeseat-code="G-DR-9">DR9</button></td>
                        <td><button class="seat available" data-seat-code="G-DR-10">DR10</button></td>
                        <td>DR</td>
                    </tr>
                    <tr>
                        <td>CL</td>
                        <td><button class="seat available" data-seat-code="G-CL-1">CL1</button></td>
                        <td><button class="seat available" data-seat-code="G-CL-2">CL2</button></td>
                        <td><button class="seat available" data-seat-code="G-CL-3">CL3</button></td>
                        <td><button class="seat available" data-seat-code="G-CL-4">CL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="G-CR-5">CR5</button></td>
                        <td><button class="seat available" data-seat-code="G-CR-6">CR6</button></td>
                        <td><button class="seat available" data-seat-code="G-CR-7">CR7</button></td>
                        <td><button class="seat available" data-seat-code="G-CR-8">CR8</button></td>
                        <td><button class="seat available" data-seat-code="G-CR-9">CR9</button></td>
                        <td><button class="seat available" data-seat-code="G-CR-10">CR10</button></td>
                        <td>CR</td>
                    </tr>
                    <tr>
                        <td>BL</td>
                        <td><button class="seat available" data-seat-code="G-BL-1">BL1</button></td>
                        <td><button class="seat available" data-seat-code="G-BL-2">BL2</button></td>
                        <td><button class="seat available" data-seat-code="G-BL-3">BL3</button></td>
                        <td><button class="seat available" data-seat-code="G-BL-4">BL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="G-BR-5">BR5</button></td>
                        <td><button class="seat available" data-seat-code="G-BR-6">BR6</button></td>
                        <td><button class="seat available" data-seat-code="G-BR-7">BR7</button></td>
                        <td><button class="seat available" data-seat-code="G-BR-8">BR8</button></td>
                        <td><button class="seat available" data-seat-code="G-BR-9">BR9</button></td>
                        <td><button class="seat available" data-seat-code="G-BR-10">BR10</button></td>
                        <td>BR</td>
                    </tr>
                    <tr>
                        <td>AL</td>
                        <td><button class="seat available" data-seat-code="G-AL-1">AL1</button></td>
                        <td><button class="seat available" data-seat-code="G-AL-2">AL2</button></td>
                        <td><button class="seat available" data-seat-code="G-AL-3">AL3</button></td>
                        <td><button class="seat available" data-seat-code="G-AL-4">AL4</button></td>
                        <td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="G-AR-5">AR5</button></td>
                        <td><button class="seat available" data-seat-code="G-AR-6">AR6</button></td>
                        <td><button class="seat available" data-seat-code="G-AR-7">AR7</button></td>
                        <td><button class="seat available" data-seat-code="G-AR-8">AR8</button></td>
                        <td><button class="seat available" data-seat-code="G-AR-9">AR9</button></td>
                        <td><button class="seat available" data-seat-code="G-AR-10">AR10</button></td>
                        <td>AR</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Platinum Section -->
        <div class="seat-type-layout-section" id="platinum-layout" style="display: none;">
            <table>
                <thead>
                    <tr>
                        <th colspan="14">Platinum Class</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td><td ></td><td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="P-X-19">X19</button></td>
                        <td><button class="seat available" data-seat-code="P-X-18">X18</button></td>
                        <td><button class="seat available" data-seat-code="P-X-17">X17</button></td>
                        <td><button class="seat available" data-seat-code="P-X-16">X16</button></td>
                        <td><button class="seat available" data-seat-code="P-X-15">X15</button></td>
                        <td></td><td ></td><td ></td>
                    </tr>
                    <tr>
                        <td></td><td ></td><td ></td><td ></td><td ></td><td ></td>
                        <td><button class="seat available" data-seat-code="P-X-14">X14</button></td>
                        <td><button class="seat available" data-seat-code="P-X-13">X13</button></td>
                        <td><button class="seat available" data-seat-code="P-X-12">X12</button></td>
                        <td><button class="seat available" data-seat-code="P-X-11">X11</button></td>
                        <td><button class="seat available" data-seat-code="P-X-10">X10</button></td>
                        <td></td><td ></td><td ></td>
                    </tr>
                    <tr>
                        <td></td><td ></td><td ></td><td ></td><td ></td><td></td>
                        <td><button class="seat available" data-seat-code="P-X-9">X9</button></td>
                        <td><button class="seat available" data-seat-code="P-X-8">X8</button></td>
                        <td><button class="seat available" data-seat-code="P-X-7">X7</button></td>
                        <td><button class="seat available" data-seat-code="P-X-6">X6</button></td>
                        <td><button class="seat available" data-seat-code="P-X-5">X5</button></td>
                        <td ></td><td ></td><td ></td>
                    </tr>
                    <tr>
                        <td></td><td ></td><td ></td><td ></td><td ></td><td></td>
                        <td><button class="seat available" data-seat-code="P-X-4">X4</button></td>
                        <td><button class="seat available" data-seat-code="P-X-3">X3</button></td>
                        <td><button class="seat available" data-seat-code="P-X-2">X2</button></td>
                        <td><button class="seat available" data-seat-code="P-X-1">X1</button></td>
                        <td></td><td ></td><td ></td><td ></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <form action="{{ route('booking.store') }}" method="POST">
        @csrf
        @method('post')
        <input id="selected-seats" name="selected_seats" >
            <input id="selected-date" name="selected_date" value="{{ $show->date }}" >
            <input id="time" name="time" value="{{ $show->time }}" >
            <input id="selected-movie-id" name="movie_id" value="{{ $show->id }}" >
            <input id="selected-movie-name" name="movie_name" value="{{ $show->movie_name }}" >
            <input id="selected-seat-type" name="seat_type" >
        <button type="submit" name="reserve_seats" class="button">Reserve Seats</button>
        <button type="submit" name="confirm_booking" id="confirm-booking" class="button">Confirm Booking</button>
    </form>
</div>

<script>
    let selectedSeats = []; // Array to hold selected seats.

    // Use booked seats passed from the backend
    const bookedSeats = @json($bookedSeats); // This array is injected from the backend

    document.addEventListener('DOMContentLoaded', () => {
        // Mark booked seats dynamically
        document.querySelectorAll('.seat').forEach(seat => {
    const seatCode = seat.getAttribute('data-seat-code'); // Get the seat code from the button

    if (bookedSeats.hasOwnProperty(seatCode)) {
        if (bookedSeats[seatCode]) {
            // If the status is true, mark as booked
            seat.classList.add('booked'); // Add 'booked' class for styling
            seat.disabled = true; // Disable button (optional for accessibility)
        } else {
            // If the status is false, mark as reserved
            seat.classList.add('reserved'); // Add 'reserved' class for styling
            seat.disabled = true; // Disable button
        }
    }

    // Add click event for non-booked and non-reserved seats
    if (!seat.classList.contains('booked') && !seat.classList.contains('reserved')) {
        seat.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSeatSelection(seatCode, seat);
        });
    }
});

        // Event listeners for seat type selection
        document.querySelectorAll('#seat-types button').forEach(button => {
            button.addEventListener('click', () => {
                const seatType = button.dataset.type;

                // Hide all layouts
                document.querySelectorAll('.seat-type-layout-section').forEach(section => {
                    section.style.display = 'none';
                });

                // Show the selected layout
                document.getElementById(`${seatType.toLowerCase()}-layout`).style.display = 'block';

                // Set the selected seat type in the hidden input field
                document.getElementById('selected-seat-type').value = seatType;
            });
        });
    });

    function toggleSeatSelection(seatCode, seatButton) {
        if (!seatCode) {
            console.error('No seat code provided');
            return;
        }

        // Toggle seat selection
        if (selectedSeats.includes(seatCode)) {
            // If already selected, remove from the array
            selectedSeats = selectedSeats.filter(seat => seat !== seatCode);
            seatButton.classList.remove('selected');
        } else {
            // Add to the array if not selected
            selectedSeats.push(seatCode);
            seatButton.classList.add('selected');
        }

        // Update the hidden input with selected seats
        document.getElementById('selected-seats').value = JSON.stringify(selectedSeats);
        console.log(`Currently selected seats: ${selectedSeats}`);
    }

</script>

<style>

        table {
            margin: 10px auto;
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            border: 0px solid black;
            padding: 5px;
            text-align: center;
            width: 30px;
            height: 30px;
        }

    .seat-type-layout-section {
        margin-top: 20px;
    }

    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
    }

    .seat:hover {
        background-color: #ddd;
    }

    .seat.selected {
        background-color: #007bff;
        color: white;
        border: 1px solid #0056b3;
    }

    .seat.booked {
        background-color: #e81414;
        cursor: not-allowed;
    }

    .seat.reserved {
    background-color: #ffc107; /* Yellow for reserved */
    cursor: not-allowed;
}

    .seat-type-layout-section table {
        margin: 0 auto;
        border-collapse: collapse;
    }

    .seat-type-layout-section th {
        text-align: center;
        font-weight: bold;
    }
</style>
@endsection
