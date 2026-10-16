<?php
// app/models/AdminModel.php (o el modelo administrativo que uses)

class AdminModel {
    private $db;

    public function __construct($databaseConnection) {
        $this->db = $databaseConnection;
    }

    public function obtenerMetricasDashboard() {
        // 1. Total de ingresos acumulados en pedidos/ventas
        $stmtVentas = $this->db->query("SELECT SUM(total) AS total_ventas FROM pedidos WHERE estado = 'completado'");
        $totalVentas = $stmtVentas->fetch(PDO::FETCH_ASSOC)['total_ventas'] ?? 0;

        // 2. Cantidad total de pedidos realizados
        $stmtPedidos = $this->db->query("SELECT COUNT(*) AS total_pedidos FROM pedidos");
        $totalPedidos = $stmtPedidos->fetch(PDO::FETCH_ASSOC)['total_pedidos'] ?? 0;

        // 3. Cantidad de clientes registrados
        $stmtClientes = $this->db->query("SELECT COUNT(*) AS total_clientes FROM usuarios WHERE role_id = 2");
        $totalClientes = $stmtClientes->fetch(PDO::FETCH_ASSOC)['total_clientes'] ?? 0;

        // 4. Últimas 5 transacciones
        $stmtUltimos = $this->db->query("
            SELECT p.id, u.nombre AS cliente, p.total, p.fecha, p.estado 
            FROM pedidos p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha DESC 
            LIMIT 5
        ");
        $ultimasVentas = $stmtUltimos->fetchAll(PDO::FETCH_ASSOC);

        return [
            'totalVentas'   => $totalVentas,
            'totalPedidos'  => $totalPedidos,
            'totalClientes' => $totalClientes,
            'ultimasVentas' => $ultimasVentas
        ];
    }
}