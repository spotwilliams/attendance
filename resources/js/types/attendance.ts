export interface Base {
    id: number;
    nombre: string;
}

export interface Shift {
    id: number;
    codigo: string;
    descripcion: string;
}

export interface Area {
    id: number;
    nombre: string;
}

export interface Role {
    id: number;
    nombre: string;
}

export interface AttendanceType {
    id: number;
    codigo: string;
    descripcion: string;
    color: string;
    color_letra: string;
}

export interface AttendanceRecord {
    id: number;
    id_agente: number;
    fecha: string;
    id_tipo_presentismo: number;
    injustificado: boolean;
    tipo_presentismo?: AttendanceType;
}

export interface ContractType {
    id: number;
    descripcion: string;
}

export interface Contract {
    id: number;
    id_tipo_contrato: number;
    tipo_contrato?: ContractType;
}

export interface Assignment {
    id: number;
    turno?: Shift;
    area?: Area;
    funcion?: Role;
}

export interface Agent {
    id: number;
    nombre: string;
    apellido: string;
    cuit: string;
    observacion: string | null;
    presentismos: AttendanceRecord[];
    contrato: Contract | null;
    operativo: Assignment | null;
}

export interface PaginatedAgents {
    data: Agent[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
}

export interface StoreResponse {
    message: string;
    code: number;
    agente: number;
    presentismo: AttendanceRecord | null;
}

export interface TypesResponse {
    types: AttendanceType[];
    has_contract: boolean;
}

export interface Filters {
    base_id: number | null;
    shifts: number[];
    areas: number[];
    roles: number[];
    date_from: string;
    date_to: string;
}
