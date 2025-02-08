export interface Payment {
    id?: number; 
    date: string;
    court_hours: number;
    court_rate: string; 
    shuttle_num: number;
    shuttle_rate: string;
    total_cost: string;
    payment_per_person: string;
    created_at?: string; 
  }