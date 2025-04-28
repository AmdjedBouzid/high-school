import { useEffect, useState } from "react";
import Label from "../../form/Label";
import Input from "../../form/input/InputField";
import Button from "../button/Button";
import { ChevronDown } from "lucide-react";
import { toast } from "react-toastify";
import { useTheme } from "../../../context/ThemeContext";
import axiosInstance from "../../../utils/Interceptor";
import Loader from "../../myComponnets/Loader";
interface closeModalProps {
  closeModal1: () => void;
  action: "add" | "edit";
  confirmationItemId?: number;
}

function AddMajorModal({
  closeModal1,
  action,
  confirmationItemId,
}: closeModalProps) {
  const { majors, setMajors } = useTheme();
  const [loading, setLoading] = useState(false);
  const { grads, setGrads } = useTheme();
  const [gradId, setGradId] = useState<number>(1);
  const [majorName, setMajorName] = useState<string>("");

  const handleSave = async () => {
    try {
      setLoading(true);
      let formData: any = {};

      if (action === "add") {
        formData = {
          name: majorName,
          grade_id: gradId,
        };

        const response = await axiosInstance.post("/majors", formData);
        if (response.status === 201) {
          const responseData = response.data as any;
          const newMajor = responseData.data;
          setMajors((prev) => [...prev, newMajor]);
        }
      } else {
        if (gradId) formData.grade_id = gradId;
        if (majorName) formData.name = majorName;

        const response = await axiosInstance.patch(
          `/majors/${confirmationItemId}`,
          formData
        );

        if (response.status === 200) {
          const updatedMajor = (response.data as any).data;
          const updatedMajors = majors.map((major) =>
            major.id === updatedMajor.id ? updatedMajor : major
          );
          setMajors(updatedMajors);
        }
      }

      closeModal1();
    } catch (error: any) {
      setLoading(false);
      closeModal1();
      toast.error(error.response?.data?.message || "Failed to update major.");
    }
  };

  useEffect(() => {
    setGrads(grads.filter((grad) => grad.id !== -1));
  }, []);
  const handleGradChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const selectedGradId = parseInt(e.target.value, 10);
    setGradId(selectedGradId);
    console.log("Selected gradId:", selectedGradId); // log the selected ID
  };

  return (
    <div className="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11 ">
      <div className="px-2 pr-14">
        <h4 className="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
          {action === "add" ? "Add New Supervisor" : "Edit Supervisor"}
        </h4>
        <p className="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
          {action === "add"
            ? "all inputs are required"
            : "all inputs are not required"}
        </p>
      </div>
      <div className="flex flex-col">
        <div className="custom-scrollbar h-[350px] overflow-y-auto px-2 pb-3">
          <div className="mt-7">
            <div className="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
              <div className="col-span-2 lg:col-span-1">
                <Label>Major Name</Label>
                <Input
                  type="text"
                  value={majorName}
                  onChange={(e) => setMajorName(e.target.value)}
                />
              </div>

              <div className="col-span-2 lg:col-span-1 relative">
                <Label>Grad</Label>
                <select
                  className="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 cursor-pointer"
                  defaultValue="M"
                  value={gradId}
                  onChange={handleGradChange}
                >
                  {grads.map((grad) => (
                    <option key={grad.id} value={grad.id}>
                      {grad.name}
                    </option>
                  ))}
                </select>
                <span className="pointer-events-none absolute right-3 top-10  text-gray-500 dark:text-white/60">
                  <ChevronDown className="w-4 h-4" />
                </span>
              </div>
            </div>
          </div>
        </div>
        <div className="flex items-center gap-3 px-2 mt-6 justify-end">
          <Button
            size="sm"
            variant="outline"
            onClick={closeModal1}
            disabled={loading}
          >
            Close
          </Button>
          <Button size="sm" onClick={handleSave} disabled={loading}>
            {loading ? <Loader /> : action === "add" ? "Add" : "Update"}
          </Button>
        </div>
      </div>
    </div>
  );
}

export default AddMajorModal;
