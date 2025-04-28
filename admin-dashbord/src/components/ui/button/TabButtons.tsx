import { useState } from "react";
import clsx from "clsx";
interface TabButtonsProps {
  setSelectedTab: (tab: "majors" | "sections") => void;
  selectedTab: "majors" | "sections";
}

function TabButtons({ selectedTab, setSelectedTab }: TabButtonsProps) {
  return (
    <div className="flex mb-3">
      <button
        type="button"
        onClick={() => setSelectedTab("majors")}
        className={clsx(
          "px-7 py-3 text-sm font-medium transition-colors focus:relative rounded-md",
          selectedTab === "majors"
            ? "bg-gray-200 text-gray-900 dark:bg-white/10 dark:text-white"
            : "text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-white/70 dark:hover:bg-white/5"
        )}
      >
        Majors
      </button>
      <button
        type="button"
        onClick={() => setSelectedTab("sections")}
        className={clsx(
          "px-7 py-3 text-sm font-medium transition-colors focus:relative rounded-md",
          selectedTab === "sections"
            ? "bg-gray-200 text-gray-900 dark:bg-white/10 dark:text-white"
            : "text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-white/70 dark:hover:bg-white/5"
        )}
      >
        Sections
      </button>
    </div>
  );
}

export default TabButtons;
