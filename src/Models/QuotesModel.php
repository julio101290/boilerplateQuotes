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

    public function mdlGetQuotes($empresas) {
        $result = $this->db->table('quotes a')
                ->select(
                        'a.UUID AS UUID,
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
            a.deleted_at AS deleted_at'
                )
                ->join('custumers b', 'a.idCustumer = b.id', 'left')
                ->join('empresas c', 'a.idEmpresa = c.id', 'left')
                ->whereIn('a.idEmpresa', $empresas);

        return $result;
    }

    /**
     * Search by filters
     */
    public function mdlGetQuotesFilters($empresas, $from, $to) {
        $result = $this->db->table('quotes a')
                ->select("
            a.UUID AS UUID,
            a.id AS id,
            b.firstname,
            b.lastname,
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

        return $result;
    }

    /**
     * Obtener Cotización por UUID
     */
    public function mdlGetQuoteUUID($uuid, $empresas) {
        $dbDriver = $this->db->getPlatform(); // Detecta si es MySQL o PostgreSQL
        // Nombre completo del cliente según el motor
        $nameExpression = $dbDriver === 'Postgre' ? "(b.firstname || ' ' || b.lastname) AS \"nameCustumer\"" : "CONCAT(b.firstname, ' ', b.lastname) AS nameCustumer";

        $result = $this->db->table('quotes a')
                ->select("
            a.idCustumer,
            a.idSucursal,
            a.folio,
            a.quoteTo,
            a.UUID,
            a.idUser,
            a.id,
            {$nameExpression},
            b.firstname AS firstname,
            b.lastname AS lastname,
            b.razonSocial AS razonSocial,
            a.idEmpresa,
            c.nombre AS nombreEmpresa,
            a.listProducts,
            a.date,
            a.dateVen,
            a.total,
            a.taxes,
            a.IVARetenido,
            a.ISRRetenido,
            a.subTotal,
            a.RFCReceptor,
            a.usoCFDI,
            a.metodoPago,
            a.formaPago,
            a.razonSocialReceptor,
            a.codigoPostalReceptor,
            a.regimenFiscalReceptor,
            a.delivaryTime,
            a.idSell,
            a.generalObservations,
            a.created_at,
            a.updated_at,
            a.deleted_at
        ")
                ->join('custumers b', 'a.idCustumer = b.id', 'inner')
                ->join('empresas c', 'a.idEmpresa = c.id', 'inner')
                ->where('a.UUID', $uuid)
                ->whereIn('a.idEmpresa', $empresas)
                ->get()
                ->getRowArray();

        return $result;
    }
}
