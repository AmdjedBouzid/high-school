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
  toDeleteOrUpdateSupervisorId: number;
  setToDeleteOrUpdateSupervisorId: React.Dispatch<React.SetStateAction<number>>;
  majors: Major[] | [];
  setMajors: React.Dispatch<React.SetStateAction<Major[] | []>>;
  toDeleteOrUpdateMajorId: number;
  setToDeleteOrUpdateMajorId: React.Dispatch<React.SetStateAction<number>>;
  grads: Grad[] | [];
  setGrads: React.Dispatch<React.SetStateAction<Grad[] | []>>;
  gradId: number;
  setGradId: React.Dispatch<React.SetStateAction<number>>;
  majorId: number;
  setMajorId: React.Dispatch<React.SetStateAction<number>>;
  sections: Section[] | [];
  setSections: React.Dispatch<React.SetStateAction<Section[] | []>>;
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
export type supervisorInputsItems = {
  key: string;
  value: string | number | boolean;
};
export type Major = {
  id: number;
  name: string;
  grade: {
    id: number;
    name: string;
  };
  created_at: string;
  updated_at: string;
};

export type Grad = {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
};

export type Section = {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
  major: {
    id: number;
    name: string;
    grade_id: number;
  };
};
