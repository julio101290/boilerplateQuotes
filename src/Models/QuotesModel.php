<?php

namespace julio101290\boilerplatequotes\Models;

use CodeIgniter\Model;

class QuotesModel extends Model {

    protected $table = 'quotes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'id',
        'idEmpresa',
        'idSucursal',
        'folio',
        'idCustumer',
        'idUser',
        'listProducts',
        'taxes',
        'subTotal',
        'total',
        'date',
        'dateVen',
        'quoteTo',
        'delivaryTime',
        'generalObservations',
        'UUID',
        'IVARetenido',
        'ISRRetenido',
        'idSell',
        'RFCReceptor',
        'usoCFDI',
        'metodoPago',
        'formaPago',
        'razonSocialReceptor',
        'codigoPostalReceptor',
        'regimenFiscalReceptor',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [
        'idEmpresa' => 'required|integer',
        'idSucursal' => 'required|integer',
        'folio' => 'required|integer',
        'idCustumer' => 'required|integer',
        'idUser' => 'required|integer',
        'listProducts' => 'permit_empty|string',
        'taxes' => 'required|decimal',
        'subTotal' => 'required|decimal',
        'total' => 'required|decimal',
        'date' => 'required|valid_date',
        'dateVen' => 'permit_empty|valid_date',
        'quoteTo' => 'permit_empty|string|max_length[512]',
        'delivaryTime' => 'permit_empty|string|max_length[512]',
        'generalObservations' => 'permit_empty|string|max_length[512]',
        'UUID' => 'permit_empty|string|max_length[36]',
        'IVARetenido' => 'required|decimal',
        'ISRRetenido' => 'required|decimal',
        'idSell' => 'required|integer',
        'RFCReceptor' => 'permit_empty|string|max_length[16]',
        'usoCFDI' => 'permit_empty|string|max_length[32]',
        'metodoPago' => 'permit_empty|string|max_length[32]',
        'formaPago' => 'permit_empty|string|max_length[32]',
        'razonSocialReceptor' => 'permit_empty|string|max_length[1024]',
        'codigoPostalReceptor' => 'permit_empty|string|max_length[5]',
        'regimenFiscalReceptor' => 'permit_empty|string|max_length[32]',
        'created_at' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'updated_at' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'deleted_at' => 'permit_empty|valid_date[Y-m-d H:i:s]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

public function mdlGetQuotes($empresas, $params = [])
{
    $builder = $this->db->table('quotes a')
        ->select("
            a.UUID AS UUID,
            a.id AS id,
            b.firstname, 
            b.lastname, 
            b.razonSocial as razonSocial,
            a.idCustumer AS idCustumer,
            a.folio AS folio,
            a.date AS date,
            b.email AS correoCliente,
            a.dateVen AS dateVen,
            a.total AS total,
            a.taxes AS taxes,
            a.IVARetenido AS IVARetenido,
            a.ISRRetenido AS ISRRetenido,
            a.subTotal AS subTotal,
            a.delivaryTime AS delivaryTime,
            a.generalObservations AS generalObservations,
            a.RFCReceptor AS RFCReceptor,
            a.usoCFDI AS usoCFDI,
            a.metodoPago AS metodoPago,
            a.formaPago AS formaPago,
            a.razonSocialReceptor AS razonSocialReceptor,
            a.codigoPostalReceptor AS codigoPostalReceptor,
            a.created_at AS created_at,
            a.updated_at AS updated_at,
            a.idSell AS idSell,
            a.deleted_at AS deleted_at
        ")
        ->join('custumers b', 'a.idCustumer = b.id', 'left')
        ->join('empresas c', 'a.idEmpresa = c.id', 'left')
        ->whereIn('a.idEmpresa', $empresas);

    // Filtros por columna
    if (!empty($params['columns'])) {
        foreach ($params['columns'] as $col) {
            if (!empty($col['search']['value'])) {
                $builder->like($col['data'], $col['search']['value']);
            }
        }
    }

    // Ordenamiento
    if (!empty($params['order'])) {
        foreach ($params['order'] as $ord) {
            $colIndex = $ord['column'];
            $dir = $ord['dir'] ?? 'asc';
            $colName = $params['columns'][$colIndex]['data'];
            $builder->orderBy($colName, $dir);
        }
    }

    // Paginación
    if (isset($params['length']) && $params['length'] != -1) {
        $builder->limit($params['length'], $params['start']);
    }

    $data = $builder->get()->getResultArray();

    // Total sin filtros
    $total = $this->db->table('quotes a')
        ->join('custumers b', 'a.idCustumer = b.id', 'left')
        ->join('empresas c', 'a.idEmpresa = c.id', 'left')
        ->whereIn('a.idEmpresa', $empresas)
        ->countAllResults();

    return [
        'data' => $data,
        'recordsTotal' => $total,
        'recordsFiltered' => count($data),
    ];
}


    /**
     * Search by filters
     */
    public function mdlGetQuotesFilters($empresas, $from, $to, $params = []) {
        $builder = $this->db->table('quotes a')
                ->select("
            a.UUID AS UUID,
            a.id AS id,
            b.firstname as firstname,
            b.lastname as lastname,
            b.razonSocial,
            a.idCustumer AS idCustumer,
            a.folio AS folio,
            a.date AS date,
            b.email AS correoCliente,
            a.dateVen AS dateVen,
            a.total AS total,
            a.taxes AS taxes,
            a.IVARetenido AS IVARetenido,
            a.ISRRetenido AS ISRRetenido,
            a.subTotal AS subTotal,
            a.delivaryTime AS delivaryTime,
            a.generalObservations AS generalObservations,
            a.RFCReceptor AS RFCReceptor,
            a.usoCFDI AS usoCFDI,
            a.metodoPago AS metodoPago,
            a.formaPago AS formaPago,
            a.razonSocialReceptor AS razonSocialReceptor,
            a.codigoPostalReceptor AS codigoPostalReceptor,
            a.created_at AS created_at,
            a.updated_at AS updated_at,
            a.idSell AS idSell,
            a.deleted_at AS deleted_at
        ")
                ->join('custumers b', 'a.idCustumer = b.id', 'left')
                ->join('empresas c', 'a.idEmpresa = c.id', 'left')
                ->where('a.date >=', $from . ' 00:00:00')
                ->where('a.date <=', $to . ' 23:59:59')
                ->whereIn('a.idEmpresa', $empresas);

        // Filtros por columna
        if (!empty($params['columns'])) {
            foreach ($params['columns'] as $col) {
                if (!empty($col['search']['value'])) {
                    $builder->like($col['data'], $col['search']['value']);
                }
            }
        }

        // Orden dinámico
        if (!empty($params['order'])) {
            foreach ($params['order'] as $ord) {
                $colIndex = $ord['column'];
                $dir = $ord['dir'] ?? 'asc';
                $colName = $params['columns'][$colIndex]['data'];
                $builder->orderBy($colName, $dir);
            }
        }

        // Paginación
        if (isset($params['length']) && $params['length'] != -1) {
            $builder->limit($params['length'], $params['start']);
        }

        $data = $builder->get()->getResultArray();

        // Total sin filtros (para recordsTotal)
        $total = $this->db->table('quotes a')
                ->join('custumers b', 'a.idCustumer = b.id', 'left')
                ->join('empresas c', 'a.idEmpresa = c.id', 'left')
                ->where('a.date >=', $from . ' 00:00:00')
                ->where('a.date <=', $to . ' 23:59:59')
                ->whereIn('a.idEmpresa', $empresas)
                ->countAllResults();

        return [
            'data' => $data,
            'recordsTotal' => $total,
            'recordsFiltered' => count($data),
        ];
    }

    /**
     * Obtener Cotización por UUID
     */
    public function mdlGetQuoteUUID($uuid, $empresas) {
        $builder = $this->db->table('quotes a');

        // Detectar motor de base de datos
        $dbDriver = $this->db->getPlatform(); // 'Postgre' o 'MySQLi'
        $dbDriver = $this->db->getPlatform();
        $nameExpression = $dbDriver === 'Postgre' ? '(b.firstname || \' \' || b.lastname) AS "nameCustumer"' : "CONCAT(b.firstname, ' ', b.lastname) AS nameCustumer";

        $builder->select("
        a.idCustumer AS idCustumer,
        a.idSucursal AS idSucursal,
        a.folio AS folio,
        a.quoteTo AS quoteTo,
        a.UUID AS UUID,
        a.idUser AS idUser,
        a.id AS id,
        $nameExpression,
        b.firstname AS firstname,
        b.lastname AS lastname,
        b.razonSocial AS razonSocial,
        a.idEmpresa AS idEmpresa,
        c.nombre AS nombreEmpresa,
        a.listProducts AS listProducts,
        a.date AS date,
        a.dateVen AS dateVen,
        a.total AS total,
        a.taxes AS taxes,
        a.IVARetenido AS IVARetenido,
        a.ISRRetenido AS ISRRetenido,
        a.subTotal AS subTotal,
        a.RFCReceptor AS RFCReceptor,
        a.usoCFDI AS usoCFDI,
        a.metodoPago AS metodoPago,
        a.formaPago AS formaPago,
        a.razonSocialReceptor AS razonSocialReceptor,
        a.codigoPostalReceptor AS codigoPostalReceptor,
        a.regimenFiscalReceptor AS regimenFiscalReceptor,
        a.delivaryTime AS delivaryTime,
        a.idSell AS idSell,
        a.generalObservations AS generalObservations,
        a.created_at AS created_at,
        a.updated_at AS updated_at,
        a.deleted_at AS deleted_at
    "); // 'false' para usar alias y expresiones sin que se escapen

        $builder->join('custumers b', 'a.idCustumer = b.id');
        $builder->join('empresas c', 'a.idEmpresa = c.id');
        $builder->where('a.UUID', $uuid);
        $builder->whereIn('a.idEmpresa', $empresas);

        return $builder->get()->getRowArray();
    }
}
