export interface Payment {
    id?: number; 
    date: string;
    court_hours: number;
    court_rate: number; 
    shuttle_num: number;
    shuttle_rate: number;
    total_cost: number;
    payment_per_person: number;
    created_at?: string; 
  }