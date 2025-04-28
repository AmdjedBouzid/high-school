import { User } from "../utils/types";
import axiosInstance from "./Interceptor";
export const getToken = (): string | null => {
  return localStorage.getItem("token");
};

export const getCurrentUser = async (): Promise<User | null> => {
  try {
    const response = await axiosInstance.get("/profile");
    const data = response.data as { data: User };
    return data.data;
  } catch (error) {
    return null;
  }
};

export function formatCustomDate(isoString: string): string {
  const date = new Date(isoString);

  const hours = date.getHours().toString().padStart(2, "0");
  const minutes = date.getMinutes().toString().padStart(2, "0");
  const day = date.getDate().toString().padStart(2, "0");
  const month = (date.getMonth() + 1).toString().padStart(2, "0");
  const year = date.getFullYear();

  return `${hours}:${minutes} ${day}/${month}/${year}`;
}

export const getGradById = (id: number): string => {
  const grads = [
    { id: 1, name: "First Year" },
    { id: 2, name: "Second Year" },
    { id: 3, name: "Third Year" },
    { id: -1, name: "All" },
  ];
  const grad = grads.find((grad) => grad.id === id);

  return grad ? grad.name : "Unknown Grad";
};
