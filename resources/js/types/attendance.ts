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

export interface Agent {
    id: number;
    nombre: string;
    apellido: string;
    cuit: string;
    contract_type: string | null;
    has_contract: boolean;
    presentismos: AttendanceRecord[];
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

export interface AttendanceComment {
    id: number;
    id_presentismo: number;
    comentario: string;
    usuario: string;
    created_at: string;
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
