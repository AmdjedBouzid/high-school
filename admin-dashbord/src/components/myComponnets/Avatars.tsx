import React from "react";

export const AdminAvatar = () => {
  return (
    <div className="w-full h-full rounded-full bg-red-600 flex items-center justify-center text-white font-bold shadow-md">
      <svg
        className="w-full h-full"
        fill="none"
        stroke="currentColor"
        strokeWidth="2"
        viewBox="0 0 24 24"
      >
        <path d="M12 2l7 4v6c0 5.25-3.5 9.75-7 11-3.5-1.25-7-5.75-7-11V6l7-4z" />
      </svg>
    </div>
  );
};

export const EmployeeAvatar = () => {
  return (
    <div className="w-full h-full rounded-full bg-blue-500 flex items-center justify-center text-white font-bold shadow-md">
      <svg
        className="w-full h-full"
        fill="none"
        stroke="currentColor"
        strokeWidth="2"
        viewBox="0 0 24 24"
      >
        <path d="M5.121 17.804A11.954 11.954 0 0112 15c2.137 0 4.134.564 5.879 1.548M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </div>
  );
};
