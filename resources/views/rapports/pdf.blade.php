<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Congés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            color: #0d6efd;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #0d6efd;
            color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>UNIVERSITÉ - GESTION DES CONGÉS</h2>
    <p class="subtitle">
        Rapport des congés dus —
        @if($type == 'direction') Directions
        @elseif($type == 'ufr') UFR
        @else Rectorat / Vice-Recteur
        @endif
        — {{ date('d/m/Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Matricule</th>
                <th>Nom & Prénom</th>
                <th>Lieu d'affectation</th>
                <th>Type</th>
                <th>Jours de congés dus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agents as $index => $agent)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $agent->matricule_solde }}</td>
                <td>{{ $agent->nom }} {{ $agent->prenom }}</td>
                <td>{{ $agent->lieu_affectation }}</td>
                <td>{{ ucfirst($agent->type_agent) }}</td>
                <td><strong>{{ $agent->jours_conges_dus }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center">Aucun agent trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Généré le {{ date('d/m/Y à H:i') }} — Plateforme Gestion des Congés
    </div>
</body>
</html>
