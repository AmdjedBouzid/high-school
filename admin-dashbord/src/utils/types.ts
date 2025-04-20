import React from "react";

export type User = {
  id: number;
  first_name: string;
  last_name: string;
  username: string;
  email: string;
  role: string; // e.g. "super-admin"
  created_at: string; // ISO date string
  updated_at: string; // ISO date string
};
export type ThemeContextType = {
  theme: Theme;
  toggleTheme: () => void;
  user: User | null;
  setUser: React.Dispatch<React.SetStateAction<User | null>>;
  employees: User[];
  setEmployees: React.Dispatch<React.SetStateAction<User[]>>;
  toDeleteOrUpdateEmployeeId: number;
  setToDeleteOrUpdateEmployeeId: React.Dispatch<React.SetStateAction<number>>;
  supervisors: Supervisor[] | [];
  setSupervisors: React.Dispatch<React.SetStateAction<Supervisor[] | []>>;
};

export type Theme = "light" | "dark";
export type NavItem = {
  name: string;
  icon: React.ReactNode;
  path?: string;
  subItems?: { name: string; path: string; pro?: boolean; new?: boolean }[];
};

export type LoginResponse = {
  token: string;
  user: {
    id: number;
    first_name: string;
    last_name: string;
    username: string;
    email: string;
    role: string; // e.g. "super-admin"
    created_at: string; // ISO date string
    updated_at: string; // ISO date string
  };
};

export type Supervisor = {
  id: number;
  first_name: string;
  last_name: string;
  email: string;
  username: string;
  supervisor_info: {
    phone_number: string;
    address: string;
    sexe: "Male" | "Female";
  };
  created_at: string;
  updated_at: string;
  role: "Supervisor";
};
export type supervisorResponse = {
  data: Supervisor;
};
export type supervisorArrayResponse = {
  data: Supervisor[];
};
