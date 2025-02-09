export interface Player {
    id: number;
    player_name: string;
    pivot: {
      paid: boolean;
      payment_id: number;
      player_id: number;
    };
}
